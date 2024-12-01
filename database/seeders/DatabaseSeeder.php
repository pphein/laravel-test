<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;
use App\Models\Author;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Generate authors and books
        $authors = Author::factory()->count(10)->create();
        $books = Book::factory()->count(20)->create();

        // Attach authors to books (many-to-many relationship)
        $books->each(function ($book) use ($authors) {
            $book->authors()->attach(
                $authors->random(rand(1, 3))->pluck('id')->toArray() // Randomly attach 1-3 authors per book
            );
        });
    }
}
