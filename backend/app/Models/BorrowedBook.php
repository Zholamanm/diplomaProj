<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\BorrowedBook
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $book_id
 * @property string $borrowed_at
 * @property string $due_date
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Book|null $book
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|BorrowedBook newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BorrowedBook newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BorrowedBook query()
 * @method static \Illuminate\Database\Eloquent\Builder|BorrowedBook whereBookId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BorrowedBook whereBorrowedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BorrowedBook whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BorrowedBook whereDueDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BorrowedBook whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BorrowedBook whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BorrowedBook whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BorrowedBook whereUserId($value)
 * @mixin \Eloquent
 */
class BorrowedBook extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'book_id', 'location_id', 'borrow_check', 'quantity', 'borrowed_at', 'due_date', 'status'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function book() {
        return $this->belongsTo(Book::class);
    }
}
