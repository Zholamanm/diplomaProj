<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class BookTag extends Pivot
{
    protected $table = 'book_tags';
    protected $fillable = ['book_id', 'tag_id', 'added_at'];
}
