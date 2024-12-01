<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class BookAuthor extends Pivot
{
    protected $table = 'book_author';

    protected $fillable = [
        'book_id',
        'author_id',
    ];
}
