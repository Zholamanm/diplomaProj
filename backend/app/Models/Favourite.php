<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Favourite
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $book_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Book|null $book
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Favourite newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Favourite newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Favourite query()
 * @method static \Illuminate\Database\Eloquent\Builder|Favourite whereBookId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Favourite whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Favourite whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Favourite whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Favourite whereUserId($value)
 * @mixin \Eloquent
 */
class Favourite extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'book_id'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function book() {
        return $this->belongsTo(Book::class);
    }

    public function scopeFilter($query, $filters)
    {
        if (isset($filters['search'])) {
            $query->whereHas('book', function ($q) use ($filters) {
                $q->where('title', 'LIKE', '%' . $filters['search'] . '%')
                    ->orWhere('author', 'LIKE', '%' . $filters['search'] . '%');
            });
        }

        if (isset($filters['sortBy'])) {
            if ($filters['sortBy'] == 0) {
                $query->orderBy(Book::select('title')->whereColumn('books.id', 'favourites.book_id'), 'asc');
            } elseif ($filters['sortBy'] == 1) {
                $query->orderBy(Book::select('title')->whereColumn('books.id', 'favourites.book_id'), 'desc');
            }
        }

        if (isset($filters['selectedCategory'])) {
            $query->whereHas('book', function ($q) use ($filters) {
                $q->where('category_id', $filters['selectedCategory']);
            });
        }
    }
}
