<?php

namespace App\Models;

use App\Notifications\BookAvailableNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Support\Facades\Notification;

/**
 * App\Models\LocationBook
 *
 * @property int $id
 * @property int|null $location_id
 * @property int|null $book_id
 * @property int $quantity
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|LocationBook newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LocationBook newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LocationBook query()
 * @method static \Illuminate\Database\Eloquent\Builder|LocationBook whereBookId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LocationBook whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LocationBook whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LocationBook whereLocationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LocationBook whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LocationBook whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class LocationBook extends Pivot
{
    use HasFactory;
    protected $table = 'location_books';
    protected $fillable = ['location_id', 'book_id', 'quantity'];

    public function location()
    {
        return $this->belongsTo(Location::class);
    }
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    protected static function booted()
    {
        static::created(function ($locationBook) {
            \Log::info('LocationBook created', [
                'quantity' => $locationBook->quantity,
            ]);

            if ($locationBook->quantity > 0) {
                $users = $locationBook->book->favourites()->with('user')->get()->pluck('user');

                foreach ($users as $user) {
                    Notification::send($user, new BookAvailableNotification($locationBook));
                }
            }
        });
        static::updated(function ($locationBook) {
            \Log::info('LocationBook updated', [
                'original_quantity' => $locationBook->getOriginal('quantity'),
                'new_quantity' => $locationBook->quantity,
            ]);

            if ($locationBook->getOriginal('quantity') == 0 && $locationBook->quantity > 0) {
                $users = $locationBook->book->favourites()->with('user')->get()->pluck('user');

                foreach ($users as $user) {
                    Notification::send($user, new BookAvailableNotification($locationBook));
                }
            }
        });
    }
}
