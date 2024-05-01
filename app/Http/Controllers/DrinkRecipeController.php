<?php

namespace App\Http\Controllers;

use App\Models\DrinkRecipe;
use App\Http\Requests\RequestStoreDrinkRecipe;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class DrinkRecipeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $recipes = DrinkRecipe::orderByDesc('id');
        $recipes = $recipes->paginate(50);

        return view('dashboard.recipes.index', compact('recipes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::latest()->get();

        return view('dashboard.recipes.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RequestStoreDrinkRecipe $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $fileName = time() . '.' . $request->image->extension();
            $validated['image'] = $fileName;

            // move file
            $request->image->move(public_path('uploads/images'), $fileName);
        }

        // join ingredient array to string with comma
        $validated['ingredient'] = implode(', ', $validated['ingredient']);

        $recipe = DrinkRecipe::create($validated);

        return redirect(route('drink-recipes.index'))->with('success', 'Resep minuman berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $recipe = DrinkRecipe::with(['category:id,name', 'comments.user:id,name', 'comments.children.user:id,name'])->findOrFail($id);

        $recipe->increment('total_view');

        $resepRecommendation = $this->getRecommendedRecipes($recipe);

        return view('dashboard.recipes.show', compact('recipe', 'resepRecommendation'));
    }

    private function getRecommendedRecipes($recipe)
    {
        $ingredients = explode(', ', $recipe->ingredient);

        $resepRecommendation = DrinkRecipe::select('id', 'name', 'category_id', 'total_view', 'ingredient', 'image')
            ->where('id', '!=', $recipe->id)
            ->where(function ($query) use ($ingredients) {
                foreach ($ingredients as $ingredient) {
                    $query->orWhere('ingredient', 'LIKE', "%$ingredient%");
                }
            })
            ->orWhere('category_id', $recipe->category_id)
            ->get();

        $frequentIngredients = $this->calculateFrequentIngredients($resepRecommendation);
        $rules = $this->generateAssociationRules($resepRecommendation, $frequentIngredients);
        $recommendedRecipes = $this->applyRulesAndGetRecommendedRecipes($resepRecommendation, $rules);

        return $recommendedRecipes->filter(function ($resep) use ($recipe) {
            return $resep->id !== $recipe->id;
        });
    }

    private function calculateFrequentIngredients($resepRecommendation)
    {
        $ingredientCounts = [];
        foreach ($resepRecommendation as $resep) {
            $resepIngredients = explode(', ', $resep->ingredient);
            foreach ($resepIngredients as $ingredient) {
                $ingredientCounts[$ingredient] = isset($ingredientCounts[$ingredient]) ? $ingredientCounts[$ingredient] + 1 : 1;
            }
        }

        $minSupport = 0.1;
        $minSupportCount = $minSupport * count($resepRecommendation);
        return array_filter($ingredientCounts, function ($count) use ($minSupportCount) {
            return $count >= $minSupportCount;
        });
    }

    private function generateAssociationRules($resepRecommendation, $frequentIngredients)
    {
        $minConfidence = 0.1;
        $rules = [];
        foreach ($frequentIngredients as $ingredientA => $countA) {
            foreach ($frequentIngredients as $ingredientB => $countB) {
                if ($ingredientA !== $ingredientB) {
                    $supportAB = 0;
                    foreach ($resepRecommendation as $resep) {
                        if (strpos($resep->ingredient, $ingredientA) !== false && strpos($resep->ingredient, $ingredientB) !== false) {
                            $supportAB++;
                        }
                    }
                    $confidence = $supportAB / $countA;
                    if ($confidence >= $minConfidence) {
                        $rules[] = [
                            'antecedent' => $ingredientA,
                            'consequent' => $ingredientB,
                            'support' => $supportAB,
                            'confidence' => $confidence,
                        ];
                    }
                }
            }
        }
        return $rules;
    }

    private function applyRulesAndGetRecommendedRecipes($resepRecommendation, $rules)
    {
        $recommendedRecipes = collect();
        foreach ($rules as $rule) {
            foreach ($resepRecommendation as $resep) {
                if (strpos($resep->ingredient, $rule['antecedent']) !== false && strpos($resep->ingredient, $rule['consequent']) === false) {
                    $recommendedRecipes->put($resep->id, $resep);
                }
            }
        }
        return $recommendedRecipes->sortByDesc('total_view');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $recipe = DrinkRecipe::findOrFail($id);
        $categories = Category::latest()->get();

        return view('dashboard.recipes.edit', compact('recipe', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RequestStoreDrinkRecipe $request, $id)
    {
        $validated = $request->validated();

        $recipe = DrinkRecipe::findOrFail($id);

        $validated['image'] = $recipe->image;

        if ($request->hasFile('image')) {
            $fileName = time() . '.' . $request->image->extension();
            $validated['image'] = $fileName;

            // move file
            $request->image->move(public_path('uploads/images'), $fileName);

            // delete old file
            $oldPath = public_path('/uploads/images/' . $recipe->image);
            if (file_exists($oldPath) && $recipe->image != 'image.png') {
                unlink($oldPath);
            }
        }

        // join ingredient array to string with comma
        $validated['ingredient'] = implode(', ', $validated['ingredient']);

        $recipe->update($validated);

        return redirect(route('drink-recipes.index'))->with('success', 'Resep minuman berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $recipe = DrinkRecipe::findOrFail($id);
        // delete old file
        $oldPath = public_path('/uploads/images/' . $recipe->image);
        if (file_exists($oldPath) && $recipe->image != 'image.png') {
            unlink($oldPath);
        }
        $recipe->delete();

        return redirect(route('drink-recipes.index'))->with('success', 'Resep minuman berhasil dihapus.');
    }

    public function apiIndex()
    {
        $recipes = DrinkRecipe::with('category:id,name')->latest()
            ->get(['id', 'name', 'category_id', 'step', 'ingredient', 'purchase_link', 'total_view']);

        $recipes->map(function ($recipe) {
            $recipe->ingredient = explode(', ', $recipe->ingredient);
            return $recipe;
        });

        return response()->json($recipes);
    }

    public function apiShow($id)
    {
        $recipe = DrinkRecipe::with(['category:id,name', 'comments.user:id,name', 'comments.children.user:id,name'])->findOrFail($id);

        $recipe->increment('total_view');

        $resepRecommendation = $this->getRecommendedRecipes($recipe);

        return response()->json([
            'recipe' => $recipe,
            'resepRecommendation' => $resepRecommendation,
        ]);
    }
}
