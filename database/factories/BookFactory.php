<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    protected $model = \App\Models\Book::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence(3),
            'summary' => $this->faker->paragraph(),
            'price' => $this->faker->numberBetween(100, 1000),
            'isbn' => $this->faker->unique()->isbn13(),
            'copy_availables' => $this->faker->numberBetween(1, 20),
        ];
    }
}
