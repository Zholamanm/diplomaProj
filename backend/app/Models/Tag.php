<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

    public function scopeFilter($query, $filters)
    {
        if (isset($filters['search']))
            $query->where(function ($q) use ($filters) {
                $q->where('title', 'LIKE', '%' . $filters['search'] . '%')
                    ->orWhere('author', 'LIKE', '%' . $filters['search'] . '%');
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
