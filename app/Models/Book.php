<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'summary',
        'price',
        'isbn',
        'copy_availables',
        'copy_borrowed',
        'cover_image'
    ];

    /**
     * The authors that belong to the book.
     */
    public function authors()
    {
        return $this->belongsToMany(Author::class, 'book_author')->using(BookAuthor::class);
    }

    public function canBeBorrowed(): bool
    {
        return $this->copy_borrowed < $this->copy_availables;
    }

    public function borrow()
    {
        if (!$this->canBeBorrowed()) {
            throw new \Exception('This book cannot be borrowed.');
        }

        $this->increment('copy_borrowed');
    }

    public function returnBook()
    {
        if ($this->copy_borrowed > 0) {
            $this->decrement('copy_borrowed');
        }
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

}
