<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;

    protected $fillable = [
        'pen_name',
        'name',
        'gender',
        'biography',
    ];

    /**
     * The books that belong to the author.
     */
    public function books()
    {
        return $this->belongsToMany(Book::class, 'book_author')->using(BookAuthor::class);
    }
}
