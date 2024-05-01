<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DrinkRecipe>
 */
class DrinkRecipeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'category_id' => $this->faker->numberBetween(1, 10),
            'name' => $this->faker->name,
            'ingredient' => $this->faker->name,
            'step' => $this->faker->name,
            'image' => $this->faker->name,
            'purchase_link' => $this->faker->numberBetween(1, 10),
            'total_view' => $this->faker->numberBetween(1, 10),
        ];
    }
}
