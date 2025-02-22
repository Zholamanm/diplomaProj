<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookTag extends Model
{
    use HasFactory;

    protected $table = 'book_tag';
    protected $fillable = ['book_id', 'tag_id', 'added_at'];
}
