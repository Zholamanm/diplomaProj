<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BorrowedBook;
use App\Models\Favourite;
use App\Models\Location;
use App\Models\LocationBook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ClientController extends Controller
{
    public function getBooks(Request $request)
    {
        return [
            'books' => Book::orderBy('id', 'DESC')->filter($request->all())->paginate(10),
            'favourites' => Favourite::where('user_id', Auth::id())->get()
        ];
    }

    public function getGuestBooks(Request $request)
    {
        return Book::orderBy('id', 'DESC')->filter($request->all())->paginate(10);
    }

    public function getRecommendBooks(Request $request)
    {
        return Book::getRecommendedBooks();;
    }

    public function getCheckouts(Request $request)
    {
        return BorrowedBook::with('book', 'location')->where('user_id', Auth::id())->filter($request->all())->paginate(10);
    }


    public function getFavourites(Request $request)
    {
        return Favourite::where('user_id', Auth::id())->with('book')->filter($request->all())->paginate(10);
    }

    public function addToFavourites($id)
    {
        return Favourite::firstOrCreate([
            'user_id' => Auth::id(),
            'book_id' => $id
        ]);
    }

    public function deleteFromFavourites($id)
    {
        try {
            $deleted = Favourite::where('user_id', auth()->id())
                ->where('book_id', $id)
                ->delete();

            return response()->json([
                'success' => $deleted > 0,
                'message' => $deleted > 0
                    ? 'Book removed from favourites'
                    : 'No favourite record found to delete'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to remove from favourites',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    public function getLocations($bookId)
    {
        return LocationBook::where('book_id', $bookId)
            ->where('quantity', '>', 0)
            ->with('location')
            ->get()
            ->map(function ($locationBook) {
                return [
                    'id' => $locationBook->location->id,
                    'name' => $locationBook->location->name,
                    'address' => $locationBook->location->address,
                    'latitude' => $locationBook->location->latitude,
                    'longitude' => $locationBook->location->longitude,
                    'quantity' => $locationBook->quantity,
                ];
            });
    }

    public function getLocationById($id)
    {
        return Location::where('id', $id)->first();
    }

    public function getLocationBookById(Request $request)
    {
        $locationBooks = LocationBook::where('book_id', $request->bookId)
            ->where('location_id', $request->id)
            ->where('quantity', '>', 0)
            ->with('location')
            ->with('book')
            ->get();  // Returns a collection

        // Check if any records exist
        if ($locationBooks->isEmpty()) {
            return response()->json(['message' => 'No records found'], 404); // Optional: handle this case
        }

        // If records exist, apply the map
        return $locationBooks->map(function ($locationBook) {
            return [
                'location' => [
                    'id' => $locationBook->location->id,
                    'name' => $locationBook->location->name,
                    'address' => $locationBook->location->address,
                    'latitude' => $locationBook->location->latitude,
                    'longitude' => $locationBook->location->longitude,
                    'quantity' => $locationBook->quantity,
                ],
                'book' => $locationBook->book
            ];
        });
    }

    public function getBookById($id)
    {
        return Book::where('id', $id)->first();
    }

    public function borrow(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'quantity' => 'required|integer|min:1',
            'location_id' => 'required|exists:locations,id',
        ]);

        $userId = Auth::id();
        $locationId = $request->location_id;
        $book = Book::find($request->book_id);

        $existingCheck = BorrowedBook::where('user_id', $userId)
            ->where('location_id', $locationId)
            ->where('status', 'borrowed')
            ->value('borrow_check');

        if (!$existingCheck) {
            do {
                $existingCheck = strtoupper(Str::random(10));
            } while (BorrowedBook::where('borrow_check', $existingCheck)->exists());
        }

        // Find the book stock at this location
        $bookStock = LocationBook::where('book_id', $book->id)
            ->where('location_id', $locationId)
            ->first();

        if (!$bookStock) {
            return response()->json([
                'message' => "Book ID {$book->id} is not available at this location"
            ], 400);
        }

        if ($bookStock->quantity < $request->quantity) {
            return response()->json([
                'message' => "Not enough copies of book ID {$book->id} available at this location"
            ], 400);
        }

        // Check if the user has already borrowed this exact book at this location
        $existingBorrow = BorrowedBook::where('user_id', $userId)
            ->where('location_id', $locationId)
            ->where('book_id', $book->id)
            ->where('status', 'borrowed')
            ->first();

        if ($existingBorrow) {
            // Update existing borrow record
            $existingBorrow->increment('quantity', $request->quantity);
            $bookStock->decrement('quantity', $request->quantity);
        } else {
            // Create a new borrow record
            BorrowedBook::create([
                'user_id' => $userId,
                'book_id' => $book->id,
                'location_id' => $locationId,
                'borrow_check' => $existingCheck,
                'status' => 'borrowed',
                'borrowed_at' => now(),
                'due_date' => now()->addWeeks(2),
                'quantity' => $request->quantity,
            ]);

            // Reduce stock
            $bookStock->decrement('quantity', $request->quantity);
        }

        return response()->json([
            'message' => 'Books borrowed successfully',
            'borrow_check' => $existingCheck,
        ]);
    }
}
