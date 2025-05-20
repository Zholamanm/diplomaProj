<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    use HasFactory;

    protected $table = 'genres';
    protected $fillable = ['name', 'category_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function books()
    {
        return $this->belongsToMany(Book::class)
            ->using(BookGenre::class)
            ->withTimestamps();
    }

    public function scopeFilter($query, $filters)
    {
        if (isset($filters['search']))
            $query->where(function ($q) use ($filters) {
                $q->where('name', 'LIKE', '%' . $filters['search'] . '%');
            });

        if (isset($filters['sortBy'])){
            if($filters['sortBy'] == 0){
                $query->reorder()->orderBy('name', 'desc');
            }elseif($filters['sortBy'] == 1) {
                $query->reorder()->orderBy('name', 'asc');
            }
        }
    }
}
