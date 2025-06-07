<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BorrowedBook;
use App\Models\Category;
use App\Models\Favourite;
use App\Models\Genre;
use App\Models\Location;
use App\Models\LocationBook;
use App\Models\Review;
use App\Models\User;
use App\Services\GeoapifyService;
use App\Services\GoogleBookService;
use App\Services\OpenLibraryService;
use App\Services\WikipediaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Intervention\Image\Encoders\JpegEncoder;
use Intervention\Image\Encoders\PngEncoder;
use Intervention\Image\Laravel\Facades\Image;

class ClientController extends Controller
{
    protected $openLibrary;
    protected $geoapify;

    public function __construct(OpenLibraryService $openLibrary, GeoapifyService $geoapify)
    {
        $this->openLibrary = $openLibrary;
        $this->geoapify = $geoapify;
    }

    public function searchBook($title)
    {
        $results = $this->openLibrary->searchBookByTitle($title);

        return response()->json($results);
    }

    public function cafesNearby($latitude, $longitude)
    {
        $shops = $this->geoapify->getNearbyCafes(
            $latitude,
            $longitude,
            5000,
            7
        );

        return response()->json($shops);
    }
    public function getBookById($id)
    {
        $book = Book::with('category', 'tags', 'genres')->find($id);

        $locations = LocationBook::where('book_id', $id)
            ->where('quantity', '>', 0)
            ->with('location')
            ->get()
            ->map(function ($locationBook) {
                return [
                    'id' => $locationBook->location->id,
                    'name' => $locationBook->location->name,
                    'latitude' => $locationBook->location->latitude,
                    'longitude' => $locationBook->location->longitude,
                    'quantity' => $locationBook->quantity,
                ];
            });
        if (Auth::user()) {
            $isFav = Favourite::where('book_id', $id)->where('user_id', Auth::id())->get();
            $details = $this->searchBook($book->title);
            return [
                'book' => $book,
                'similar' => $details,
                'details' => $details,
                'locations' => $locations,
                'is_favourite' => $isFav
            ];
        } else {
            $details = $this->searchBook($book->title);
            return [
                'book' => $book,
                'similar' => $details,
                'details' => $details,
                'locations' => $locations
            ];
        }
    }

    public function getCategoryWithBooks($id)
    {
        $wikipediaService = new WikipediaService();
        $googleBookService = new GoogleBookService();
        $category = Category::with(['genres', 'books' => function($query) {
            $query->withCount('borrowedBooks')
                ->orderBy('borrowed_books_count', 'desc')
                ->with('genres', 'tags');
        }])->findOrFail($id);
        $subject = request('subject', $category->name);
        $slug = preg_replace('/[^\p{L}\p{Nd}]+/u', '_', $subject);
        $slug = trim($slug, '_');
        // Get Wikipedia data
        $wikipediaData = [
            'info' => $wikipediaService->getCategoryInfo($category->name),
            'notable_books' => $googleBookService->getBooksBySubject($subject, 5),
            'authors' => $wikipediaService->getNotableAuthors($slug)
        ];
        return response()->json([
            'data' => [
                'category' => [
                    'id' => $category->id,
                    'name' => $category->name,
                    'genres' => $category->genres
                ],
                'books' => $category->books->map(function($book) {
                    return [
                        'id' => $book->id,
                        'title' => $book->title,
                        'author' => $book->author,
                        'description' => $book->description,
                        'cover_image' => $book->cover_image,
                        'genres' => $book->genres,
                        'tags' => $book->tags
                    ];
                }),
                'wikipedia' => $wikipediaData
            ]
        ]);
    }

    public function getGenresWithMostFavoritedBook()
    {
        $genres = Genre::with(['books' => function($query) {
            $query->withCount('favourites')
                ->orderBy('favourites_count', 'desc')
                ->take(1); // Get only the most favorited book
        }])
            ->get()
            ->map(function($genre) {
                return [
                    'id' => $genre->id,
                    'name' => $genre->name,
                    'book' => $genre->books->first() ? [
                        'id' => $genre->books->first()->id,
                        'title' => $genre->books->first()->title,
                        'author' => $genre->books->first()->author,
                        'cover_image' => $genre->books->first()->cover_image,
                        'favourites_count' => $genre->books->first()->favourites_count
                    ] : null
                ];
            });

        return response()->json($genres);
    }

    public function getTopBooksByGenre($genreId)
    {
        try {
            $genre = Genre::with('category')->findOrFail($genreId);
            $wikipediaService = new WikipediaService();
            $googleBookService = new GoogleBookService();
            $books = Book::whereHas('genres', function($query) use ($genreId) {
                $query->where('genres.id', $genreId);
            })
                ->with(['reviews', 'genres'])
                ->select('books.*')
                ->selectRaw('(
                SELECT AVG(rating)
                FROM reviews
                WHERE reviews.book_id = books.id
            ) as average_rating')
                ->selectRaw('(
                SELECT COUNT(*)
                FROM reviews
                WHERE reviews.book_id = books.id
            ) as reviews_count')
                ->selectRaw('(
                SELECT COUNT(*)
                FROM favourites
                WHERE favourites.book_id = books.id
            ) as favourites_count')
                ->orderByDesc('average_rating')
                ->orderByDesc('reviews_count')
                ->orderByDesc('favourites_count')
                ->limit(10)
                ->get();
            $subject = request('subject', $genre->name);
            $slug = preg_replace('/[^\p{L}\p{Nd}]+/u', '_', $subject);
            $slug = trim($slug, '_');
            $wikipediaData = [
                'info' => $wikipediaService->getGenreInfo($genre->name),
                'notable_books' => $googleBookService->getBooksBySubject($subject, 5),
                'authors' => $wikipediaService->getNotableAuthorsByGenre($slug)
            ];
            return response()->json([
                'genre' => $genre,
                'books' => $books,
                'wikipedia' => $wikipediaData
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to fetch top books by genre',
                'error' => $e->getMessage()
            ], 500);
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
            return Book::with('category', 'tags')->orderBy('id', 'DESC')->filter($request->all())->paginate(10);
        }
    }

    public function sendReview(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'book_id' => ['required', 'integer', 'exists:books,id'],
            'comment' => ['required', 'string', 'max:1000'],
            'rating' => ['required', 'integer', 'between:1,5'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }
        $userId = Auth::id();

        Review::updateOrCreate(
            [
                'book_id' => $request->book_id,
                'user_id' => $userId
            ],
            [
                'comment' => $request->comment,
                'rating' => $request->rating
            ]
        );
        return response()->json([
            'success' => true
        ]);
    }

    public function getReviews()
    {
        return Review::where('user_id', Auth::id())->with('book')->paginate(10);
    }

    public function getProfile()
    {
        $user = Auth::user();

        $user->load('role');

        return response()->json([
            'data' => $user,
            'message' => 'Profile retrieved successfully'
        ]);
    }

    public function getUserReviews($id)
    {
        return Review::where('user_id', $id)->with('book')->paginate(10);
    }

    public function getUserProfile($id)
    {
        $user = User::find($id);

        $user->load('role');

        return response()->json([
            'data' => $user,
            'message' => 'Profile retrieved successfully'
        ]);
    }

    /**
     * Update user's profile
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:users,email,'.$user->id,
            'date_of_birth' => 'nullable|date',
            'nationality' => 'nullable|string|max:100',
            'address' => 'nullable|string|max:500',
            'phone' => 'nullable|string|max:20',
            'bio' => 'nullable|string|max:1000'
        ]);

        $user->update($validated);

        return response()->json([
            'data' => $user,
            'message' => 'Profile updated successfully'
        ]);
    }

    /**
     * Update profile picture with cropping
     */
    public function updatePicture(Request $request)
    {
        $request->validate([
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB max
        ]);

        $user = Auth::user();
        $imageFile = $request->file('profile_picture');

        $filename = 'profile_' . time() . '.' . $imageFile->getClientOriginalExtension();

        $directory = 'public/profile_pictures/' . $user->id;
        Storage::makeDirectory($directory);

        // Read the image with Intervention Image
        $image = Image::read($imageFile);

        // Resize and crop to square 300x300
        $croppedImage = $image->coverDown(300, 300);
        $extension = strtolower($imageFile->getClientOriginalExtension());
        switch ($extension) {
            case 'jpeg':
            case 'jpg':
                $encoder = new JpegEncoder(80); // 80 is quality
                break;
            case 'png':
                $encoder = new PngEncoder(80);
                break;
            default:
                // fallback to jpeg if unknown
                $encoder = new JpegEncoder(80);
                break;
        }
        $croppedImage = $image->encode($encoder);
        // Save cropped image to storage
        $croppedPath = $directory . '/cropped_' . $filename;
        Storage::put($croppedPath, $croppedImage);

        // Save original uploaded image to storage

        $originalPath = $imageFile->store('profile_pictures', 'public');

        // Delete old images if exist
        if ($user->profile_picture) {
            Storage::delete($user->profile_picture);
            // Try to delete corresponding cropped image as well
            $oldCroppedPath = preg_replace('/\/profile_/', '/cropped_profile_', $user->profile_picture);
            Storage::delete($oldCroppedPath);
        }

        // Save new original image path (or you can save croppedPath if you prefer to show cropped)
        $user->profile_picture = $originalPath;
        $user->save();

        return response()->json([
            'profile_picture' => $user->profile_picture,
            'message' => 'Profile picture updated successfully'
        ]);
    }
    public function getRecommendBooks(Request $request)
    {
        return Book::getRecommendedBooks();
    }

    public function getRecentReviews()
    {
        $reviews = Review::with(['user', 'book'])
            ->latest()
            ->take(10) // or whatever limit you want
            ->get();

        return response()->json([
            'data' => $reviews,
            'message' => 'Recent reviews retrieved successfully'
        ]);
    }

    public function getSimilarBooks(Request $request)
    {
        $data = $request->validate([
            'category_id' => 'nullable',
            'tags'        => 'nullable',
            'genre_id'        => 'nullable',
            'locations'        => 'nullable',
        ]);

        // 2) Build the query—matching category OR any of the tags OR the one genre:
        $query = Book::query()
            ->where(function ($q) use ($data) {
                if (! empty($data['category_id'])) {
                    $q->where('category_id', $data['category_id']);
                }

                if (! empty($data['tags'])) {
                    $q->orWhereHas('tags', function ($q2) use ($data) {
                        $q2->whereIn('tags.id', $data['tags']);
                    });
                }
                if (! empty($data['genre_id'])) {
                    $q->orWhereHas('tags', function ($q2) use ($data) {
                        $q2->whereIn('tags.id', $data['tags']);
                    });
                }
                if (! empty($data['locations'])) {
                    $q->orWhereHas('locations', function ($q2) use ($data) {
                        $q2->whereIn('locations.id', $data['locations']);
                    });
                }
            });

        $similar = $query
            ->inRandomOrder()
            ->limit(7)
            ->get();

        return response()->json([
            'data' => $similar
        ]);
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

    public function getCategoriesWithMostBorrowedBooks()
    {
        $categories = Category::with(['books' => function($query) {
            $query->withCount('borrowedBooks')
                ->orderBy('borrowed_books_count', 'desc')
                ->take(1); // Get only the most borrowed book
        }])
            ->limit(7) // Limit to 7 categories
            ->get()
            ->map(function($category) {
                return [
                    'id' => $category->id,
                    'name' => $category->name,
                    'book' => $category->books->first() ? [
                        'cover_image' => $category->books->first()->cover_image,
                        'title' => $category->books->first()->title
                    ] : null
                ];
            });

        return response()->json($categories);
    }

    public function getCheckouts(Request $request)
    {
        return BorrowedBook::with([
            'book' => function ($query) {
                $query->with(['reviews' => function ($q) {
                    $q->where('user_id', Auth::id());
                }]);
            },
            'location'
        ])->where('user_id', Auth::id())
            ->filter($request->all())
            ->paginate(10);
    }

    public function getFavourites(Request $request)
    {
        return Favourite::where('user_id', Auth::id())->with('book')->filter($request->all())->paginate(10);
    }

    public function getUserFavourites($id)
    {
        return Favourite::where('user_id', $id)->with('book')->paginate(10);
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
            ->with('book', 'book.category', 'book.genres', 'book.tags', 'book.reviews')
            ->get();
        $book = Book::withCount('reviews')->find($request->bookId);

        if ($locationBooks->isEmpty()) {
            return response()->json(['message' => 'No records found'], 404); // Optional: handle this case
        }
        $locationBook = $locationBooks->first();
        $latitude = $locationBook->location->latitude;
        $longitude = $locationBook->location->longitude;
        $shops = $this->cafesNearby($latitude, $longitude);
        return $locationBooks->map(function ($locationBook) use ($shops, $book) {
            return [
                'location' => [
                    'id' => $locationBook->location->id,
                    'name' => $locationBook->location->name,
                    'latitude' => $locationBook->location->latitude,
                    'longitude' => $locationBook->location->longitude,
                    'quantity' => $locationBook->quantity,
                ],
                'book' => $locationBook->book,
                'reviews_count' => $book->reviews_count,
                'shops' => $shops
            ];
        });
    }

    public function getLocationList(Request $request)
    {
        // Get books with their available locations
        $books = Book::query()
            ->with(['locations' => function($query) {
                $query->where('quantity', '>', 0)
                    ->select('locations.id', 'name', 'latitude', 'longitude')
                    ->withPivot('quantity');
            }], 'category')
            ->whereHas('locations', function($query) {
                $query->where('quantity', '>', 0);
            })
            ->whereHas('category')
            ->select('books.id', 'title', 'author', 'description', 'cover_image', 'category_id', 'updated_at')
            ->get();

        // Transform the data to match frontend expectations
        $transformedData = [];

        foreach ($books as $book) {
            foreach ($book->locations as $location) {
                $transformedData[] = [
                    'id' => $book->id,
                    'title' => $book->title,
                    'author' => $book->author,
                    'description' => $book->description,
                    'cover_image' => $book->cover_image,
                    'category' => $book->category->name,
                    'available_copies' => $location->pivot->quantity,
                    'latitude' => $location->latitude,
                    'longitude' => $location->longitude,
                    'location_id' => $location->id,
                    'location_name' => $location->name,
                    'last_activity' => $book->updated_at->toIso8601String()
                ];
            }
        }

        return $transformedData;
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
