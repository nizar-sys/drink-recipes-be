<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CommentRecipe>
 */
class CommentRecipeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'recipe_id' => 10,
            'user_id' => 1,
            'parent_id' => null,
            'comment' => $this->faker->sentence,
        ];
    }
}
