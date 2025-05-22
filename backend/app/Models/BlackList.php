<?php

namespace App\Models;

use App\Notifications\BlacklistStatusNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Notification;

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

    protected static function booted()
    {
        static::created(function ($blackList) {
            \Log::info("BlackList CREATED: ID={$blackList->id}, user_id={$blackList->user_id}");
            if ($user = $blackList->user) {
                \Log::info("-> Found user, sending notification");
                $user->notify(new BlacklistStatusNotification($blackList, 'added'));
            } else {
                \Log::warning("-> No user found for BlackList ID={$blackList->id}");
            }
        });

        static::deleted(function ($blackList) {
            \Log::info("BlackList DELETED: ID={$blackList->id}, user_id={$blackList->user_id}");
            if ($user = $blackList->user) {
                \Log::info("-> Found user, sending removal notification");
                $user->notify(new BlacklistStatusNotification($blackList, 'removed'));
            } else {
                \Log::warning("-> No user found for BlackList ID={$blackList->id}");
            }
        });
    }
}
