<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'text' => fake()->text(),
            'topic_id' => -1, // should be overrided
            'user_id' => -1 // should be overrided when the factory is called in create method call Model::factory()->create(["override_key" => $override_value])
        ];
    }
}
