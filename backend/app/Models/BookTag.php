<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * App\Models\BookTag
 *
 * @property int $id
 * @property int|null $book_id
 * @property int|null $tag_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|BookTag newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BookTag newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BookTag query()
 * @method static \Illuminate\Database\Eloquent\Builder|BookTag whereBookId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookTag whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookTag whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookTag whereTagId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookTag whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class BookTag extends Pivot
{
    protected $table = 'book_tags';
    protected $fillable = ['book_id', 'tag_id', 'added_at'];
}
