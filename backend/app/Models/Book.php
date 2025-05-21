<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * App\Models\Book
 *
 * @property int $id
 * @property string $title
 * @property string $author
 * @property string $description
 * @property string|null $cover_image
 * @property int|null $category_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\BorrowedBook> $borrowedBooks
 * @property-read int|null $borrowed_books_count
 * @property-read \App\Models\Category|null $category
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Location> $locations
 * @property-read int|null $locations_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Review> $reviews
 * @property-read int|null $reviews_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Tag> $tags
 * @property-read int|null $tags_count
 * @method static \Illuminate\Database\Eloquent\Builder|Book filter($filters)
 * @method static \Illuminate\Database\Eloquent\Builder|Book newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Book newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Book query()
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereAuthor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereCoverImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Book extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'author', 'description', 'cover_image', 'category_id'];

    protected $userId;

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function tags() {
        return $this->belongsToMany(Tag::class, 'book_tags')->using(BookTag::class);
    }

    public function genres() {
        return $this->belongsToMany(Genre::class, 'book_genres')->using(BookGenre::class);
    }

    public function reviews() {
        return $this->hasMany(Review::class);
    }

    public function borrowedBooks() {
        return $this->hasMany(BorrowedBook::class);
    }

    public function locations()
    {
        return $this->belongsToMany(Location::class, 'location_books')->using(LocationBook::class);
    }

    public function favourites()
    {
        return $this->hasMany(Favourite::class);
    }

    public function scopeFilter($query, $filters)
    {
        if (isset($filters['search']))
            $query->where(function ($q) use ($filters) {
                $q->where('title', 'LIKE', '%' . $filters['search'] . '%')
                    ->orWhere('author', 'LIKE', '%' . $filters['search'] . '%');
            });

        if (isset($filters['sortBy'])){
            if($filters['sortBy'] == 0){
                $query->reorder()->orderBy('title', 'asc');;
            }elseif($filters['sortBy'] == 1) {
                $query->reorder()->orderBy('title', 'desc');;
            }
        }

        if (isset($filters['genre_id'])) {
            $query->whereHas('genres', function ($q) use ($filters) {
                $q->where('genres.id', $filters['genre_id']);
            });
        }

        if (!empty($filters['tags']) && is_array($filters['tags'])) {
            $query->whereHas('tags', function ($q) use ($filters) {
                $q->whereIn('tags.id', $filters['tags']);
            });
        }

        if (isset($filters['selectedCategory'])) {
            $query->where('category_id', $filters['selectedCategory']);
        }
    }

    /**
     * Get top 5 recommended books ordered by number of favourites (descending)
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getRecommendedBooks()
    {
        return self::withCount('favourites')->withCount('reviews')->with('reviews')
            ->orderBy('favourites_count', 'ASC')
            ->limit(7)
            ->get();
    }

}
