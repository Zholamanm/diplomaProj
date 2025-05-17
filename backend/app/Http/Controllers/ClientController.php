<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BorrowedBook;
use App\Models\Favourite;
use App\Models\Location;
use App\Models\LocationBook;
use App\Services\GeoapifyService;
use App\Services\OpenLibraryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ClientController extends Controller
{
    protected $openLibrary;
    protected $geoapify;

    public function __construct(OpenLibraryService $openLibrary, GeoapifyService $geoapify)
    {
        $this->openLibrary = $openLibrary;
        $this->geoapify = $geoapify;
    }

    public function searchSimilar($title)
    {
        $results = $this->openLibrary->searchBooks($title);

        return response()->json($results);
    }

    public function searchBook($title)
    {
        $results = $this->openLibrary->searchBookByTitle($title);

        return response()->json($results);
    }

    public function coffeeShopsNearby($latitude, $longitude)
    {
        $shops = $this->geoapify->getNearbyCoffeeShops(
            $latitude,
            $longitude,
            500,
            7
        );

        return response()->json($shops);
    }
    public function getBookById($id)
    {
        $book = Book::with('category', 'tags')->find($id);

        $locations = LocationBook::where('book_id', $id)
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
        if (Auth::user()) {
            $isFav = Favourite::where('book_id', $id)->where('user_id', Auth::id())->get();
            return [
                'book' => $book,
                'similar' => $this->searchSimilar($book->title),
                'details' => $this->searchBook($book->title),
                'locations' => $locations,
                'is_favourite' => $isFav
            ];
        } else {
            return [
                'book' => $book,
                'similar' => $this->searchSimilar($book->title),
                'details' => $this->searchBook($book->title),
                'locations' => $locations
            ];
        }
    }

    public function getBooks(Request $request)
    {
        if(Auth::user()) {
            return [
                'books' => Book::orderBy('id', 'DESC')->filter($request->all())->paginate(10),
                'favourites' => Favourite::where('user_id', Auth::id())->get()
            ];
        } else {
            return Book::orderBy('id', 'DESC')->filter($request->all())->paginate(10);
        }
    }

    public function getRecommendBooks(Request $request)
    {
        return Book::getRecommendedBooks();;
    }

    public function getFeatured(Request $request)
    {
        $limit = $request->input('limit', 7);

        $books = Book::withCount('borrowedBooks') // borrowedBooks relationship exists in Book model
        ->orderBy('borrowed_books_count', 'desc')
            ->limit($limit)
            ->get();

        return response()->json($books);
    }

    public function getRecent(Request $request)
    {
        $limit = $request->input('limit', 7);

        $books = Book::whereHas('locations')
            ->orderBy('updated_at', 'desc')
            ->limit($limit)
            ->get();

        return response()->json($books);
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
            ->get();

        if ($locationBooks->isEmpty()) {
            return response()->json(['message' => 'No records found'], 404); // Optional: handle this case
        }
        $locationBook = $locationBooks->first();
        $latitude = $locationBook->location->latitude;
        $longitude = $locationBook->location->longitude;
        $shops = $this->coffeeShopsNearby($latitude, $longitude);
        return $locationBooks->map(function ($locationBook) use ($shops) {
            return [
                'location' => [
                    'id' => $locationBook->location->id,
                    'name' => $locationBook->location->name,
                    'address' => $locationBook->location->address,
                    'latitude' => $locationBook->location->latitude,
                    'longitude' => $locationBook->location->longitude,
                    'quantity' => $locationBook->quantity,
                ],
                'book' => $locationBook->book,
                'shops' => $shops
            ];
        });
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
