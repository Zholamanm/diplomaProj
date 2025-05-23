<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class BookGenre extends Pivot
{
    use HasFactory;

    protected $table = 'book_genres';
    protected $fillable = ['book_id','genre_id'];
}
