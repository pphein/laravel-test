<?php

namespace App\Imports;

use Illuminate\Support\Str;
use App\Models\Book;
use App\Models\Author;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BooksImport implements ToModel, WithHeadingRow
{
    /**
     * Convert each row into a Book model and associate authors.
     *
     * @param array $row
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Validate and download the cover image if a link is provided
        $coverImagePath = null;
        if (!empty($row['cover_image_link'])) {
            $imageUrl = $row['cover_image_link'];
            // $imageExtension = pathinfo($imageUrl, PATHINFO_EXTENSION);
            // $imageName = Str::random(10) . '.' . $imageExtension;
            $imageExtension = pathinfo(parse_url($imageUrl, PHP_URL_PATH), PATHINFO_EXTENSION); // Get file extension
            $imageName = Str::slug($row['title'])  . '.' . $imageExtension;

            try {
                // Use file_get_contents to get the image content from the URL
                $imageContent = file_get_contents($imageUrl);
                
                if ($imageContent === false) {
                    throw new \Exception("Unable to download image from: $imageUrl");
                }

                // Store the image in the 'cover_images' directory
                Storage::disk('public')->put('cover_images/' . $imageName, $imageContent);
                $coverImagePath = 'cover_images/' . $imageName;
            } catch (\Exception $e) {
                // Handle errors appropriately, e.g., log them or continue without the image
                Log::error('Image download error: ' . $e->getMessage());
            }
        }

        // Create or update the book
        $book = Book::updateOrCreate(
            ['isbn' => $row['isbn']], // Use ISBN as the unique identifier
            [
                'title' => $row['title'],
                'summary' => $row['summary'],
                'price' => $row['price'],
                'copy_availables' => $row['copy_availables'],
                'cover_image' => $coverImagePath, // Store the path to the image
            ]
        );

        // Handle authors (comma-separated)
        if (!empty($row['authors'])) {
            $authors = explode(',', $row['authors']); // Split authors by comma
            $authorIds = [];

            foreach ($authors as $authorName) {
                $author = Author::firstOrCreate(['pen_name' => trim($authorName)]);
                $authorIds[] = $author->id;
            }

            // Sync authors with the book
            $book->authors()->sync($authorIds);
        }

        return $book;
    }
}
