<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Instruction>
 */
class InstructionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'rank' => $this->faker->randomNumber(2),
            'ingredientAmount' => $this->faker->randomFloat(2, 1, 150),
            'description' => $this->faker->paragraphs(3, true),
        ];
    }
}
