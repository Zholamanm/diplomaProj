<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlackList extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'violation_count', 'start_date', 'expire_date'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function scopeFilter($query, $filters)
    {
        if (isset($filters['sortBy'])){
            if($filters['sortBy'] == 0){
                $query->reorder()->orderBy('id', 'desc');
            }elseif($filters['sortBy'] == 1) {
                $query->reorder()->orderBy('id', 'asc');
            }
        }
    }
}
