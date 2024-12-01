<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Author>
 */
class AuthorFactory extends Factory
{
    protected $model = \App\Models\Author::class;

    public function definition()
    {
        return [
            'pen_name' => $this->faker->unique()->name(),
            'name' => $this->faker->name(),
            'gender' => $this->faker->randomElement(['male', 'female', 'non-binary']),
            'biography' => $this->faker->paragraph(),
        ];
    }
}
