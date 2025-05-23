<?php

use App\Http\Controllers\BroadCastingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
//Route::post('/broadcasting/auth', BroadCastingController::class)->middleware('auth:api');Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/google-login', [AuthController::class, 'loginWithGoogle']);
Route::get('guest/books', [\App\Http\Controllers\ClientController::class, 'getBooks']);
Route::get('sliders', [\App\Http\Controllers\ClientController::class, 'getBooks']);
Route::get('client/books/recommend', [\App\Http\Controllers\ClientController::class, 'getRecommendBooks']);
Route::get('client/reviews/recent', [\App\Http\Controllers\ClientController::class, 'getRecentReviews']);
Route::get('client/books/similar', [\App\Http\Controllers\ClientController::class, 'getSimilarBooks']);
Route::get('client/books/featured', [\App\Http\Controllers\ClientController::class, 'getFeatured']);
Route::get('client/books/recent', [\App\Http\Controllers\ClientController::class, 'getRecent']);
Route::get('client/books/top-list', [\App\Http\Controllers\ClientController::class, 'getGenresWithMostFavoritedBook']);
Route::get('client/books/categories', [\App\Http\Controllers\ClientController::class, 'getCategoriesWithMostBorrowedBooks']);
Route::get('client/categories/{id}/books', [\App\Http\Controllers\ClientController::class, 'getCategoryWithBooks']);
Route::get('client/genres/{id}/books', [\App\Http\Controllers\ClientController::class, 'getTopBooksByGenre']);
Route::get('client/book/locations', [\App\Http\Controllers\ClientController::class, 'getLocationBookById']);
Route::get('client/locations', [\App\Http\Controllers\ClientController::class, 'getLocationList']);
Route::get('guest/books/{id}', [\App\Http\Controllers\ClientController::class, 'getBookById']);
Route::get('client/book/locations/{id}/', [\App\Http\Controllers\ClientController::class, 'getLocations']);
Route::get('client/locations/{id}', [\App\Http\Controllers\ClientController::class, 'getLocationById']);
Route::get('common_data', [\App\Http\Controllers\CommonController::class, 'index']);
Route::get('client/reviews/{id}', [\App\Http\Controllers\ClientController::class, 'getUserReviews']);
Route::get('client/profile/{id}', [\App\Http\Controllers\ClientController::class, 'getUserProfile']);
Route::get('client/book/favourite/{id}', [\App\Http\Controllers\ClientController::class, 'getUserFavourites']);
Route::middleware('auth:api')->post('/logout', [AuthController::class, 'logout']);
Route::middleware('auth:api')->get('/user-info', function (Request $request) {
    return $request->user();
});
Route::middleware('auth:api')->get('/test-auth', function () {
    return response()->json(['user' => auth()->user()]);
});
Route::middleware('auth:api')->get('/online-friends', function () {
    return response()->json([
        'online' => auth()->user()->friends()
            ->where('is_online', true)
            ->get(),
        'recently_online' => auth()->user()->friends()
            ->where('is_online', false)
            ->where('last_seen_at', '>', now()->subMinutes(15))
            ->get()
    ]);
});
Route::middleware('auth:api')->post('/user/online', function() {
    auth()->user()->update(['is_online' => true]);
    broadcast(new \App\Events\UserOnlineStatusChanged(auth()->id(), true))->toOthers();
    return response()->json(['status' => 'online']);
});

Route::middleware('auth:api')->post('/user/away', function() {
    auth()->user()->update(['is_online' => false]);
    broadcast(new \App\Events\UserOnlineStatusChanged(auth()->id(), false))->toOthers();
    return response()->json(['status' => 'away']);
});

Route::middleware('auth:api')->post('/user/offline', function() {
    auth()->user()->update(['is_online' => false]);
    broadcast(new \App\Events\UserOnlineStatusChanged(auth()->id(), false))->toOthers();
    return response()->json(['status' => 'offline']);
});

Route::middleware('auth:api')->post('/save-fcm-token', function(Request $request) {
    $request->validate(['fcm_token' => 'required|string']);

    $user = $request->user();
    $user->fcm_token = $request->fcm_token;
    $user->save();

    return response()->json(['message' => 'FCM token saved']);
});


Route::middleware(['auth:api'])->group(function () {
    Route::prefix('client')->group(function () {
        Route::get('/friends/{id}', [\App\Http\Controllers\FriendshipController::class, 'getFriends']);
        Route::post('/friends/{id}/send', [\App\Http\Controllers\FriendshipController::class, 'sendRequest']);
        Route::get('/friendship-status/{id}', [\App\Http\Controllers\FriendshipController::class, 'checkStatus']);
        Route::post('/friends/{id}/accept', [\App\Http\Controllers\FriendshipController::class, 'acceptRequest']);
        Route::post('/friends/{id}/reject', [\App\Http\Controllers\FriendshipController::class, 'rejectRequest']);
        Route::get('/chat/{id}', [\App\Http\Controllers\ChatController::class, 'index'])->name('chat');
        Route::post('/chat/{id}/send', [\App\Http\Controllers\ChatController::class, 'sendMessage']);
        Route::post('review', [\App\Http\Controllers\ClientController::class, 'sendReview']);
        Route::get('reviews', [\App\Http\Controllers\ClientController::class, 'getReviews']);
        Route::get('profile', [\App\Http\Controllers\ClientController::class, 'getProfile']);
        Route::post('profile', [\App\Http\Controllers\ClientController::class, 'updateProfile']);
        Route::post('profile/picture', [\App\Http\Controllers\ClientController::class, 'updatePicture']);
        Route::get('books/{id}', [\App\Http\Controllers\ClientController::class, 'getBookById']);
        Route::get('books', [\App\Http\Controllers\ClientController::class, 'getBooks']);
        Route::get('checkout', [\App\Http\Controllers\ClientController::class, 'getCheckouts']);
        Route::post('books/{id}/borrow', [\App\Http\Controllers\ClientController::class, 'borrow']);
        Route::get('book/favourite', [\App\Http\Controllers\ClientController::class, 'getFavourites']);
        Route::post('book/{id}/favourite', [\App\Http\Controllers\ClientController::class, 'addToFavourites']);
        Route::delete('book/{id}/favourite', [\App\Http\Controllers\ClientController::class, 'deleteFromFavourites']);
        Route::post('/locations', [\App\Http\Controllers\ClientController::class, 'borrow']);
    });
    Route::middleware(['admin_routes'])->group(function () {
// role:1 - Admin
// role:2 - Librarian
// role:3 - Member

        Route::middleware('role:1,2')->group(function () {
            Route::prefix('borrows')->group(function () {
                Route::get('', [\App\Http\Controllers\BorrowController::class, 'get']);
            });
            Route::prefix('borrow')->group(function () {
                Route::get('', [\App\Http\Controllers\BorrowController::class, 'index']);
                Route::post('/checkout', [\App\Http\Controllers\BorrowController::class, 'checkout']);
                Route::post('/return', [\App\Http\Controllers\BorrowController::class, 'returnBook']);
            });
            Route::prefix('black-list')->group(function () {
                Route::get('', [\App\Http\Controllers\BlackListController::class, 'index']);
            });
            Route::prefix('users')->group(function () {
                Route::get('', [\App\Http\Controllers\UserController::class, 'get']);
            });
            Route::prefix('books')->group(function () {
                Route::get('', [\App\Http\Controllers\BookController::class, 'get']);
            });
            Route::prefix('book')->group(function () {
                Route::get('', [\App\Http\Controllers\BookController::class, 'index']);
                Route::get('/{id}', [\App\Http\Controllers\BookController::class, 'view']);
                Route::post('/', [\App\Http\Controllers\BookController::class, 'store']);
                Route::post('/{id}', [\App\Http\Controllers\BookController::class, 'update']);
                Route::delete('/{id}', [\App\Http\Controllers\BookController::class, 'destroy']);
            });
            Route::prefix('slider')->group(function () {
                Route::get('', [\App\Http\Controllers\SliderController::class, 'index']);
                Route::get('/{id}', [\App\Http\Controllers\SliderController::class, 'view']);
                Route::post('/', [\App\Http\Controllers\SliderController::class, 'store']);
                Route::post('/{id}', [\App\Http\Controllers\SliderController::class, 'update']);
                Route::delete('/{id}', [\App\Http\Controllers\SliderController::class, 'destroy']);
                Route::post('enable/{id}', [\App\Http\Controllers\SliderController::class, 'enable']);
            });
            Route::prefix('category')->group(function () {
                Route::get('', [\App\Http\Controllers\CategoryController::class, 'index']);
                Route::get('/{id}', [\App\Http\Controllers\CategoryController::class, 'view']);
                Route::post('/', [\App\Http\Controllers\CategoryController::class, 'store']);
                Route::post('/{id}', [\App\Http\Controllers\CategoryController::class, 'update']);
                Route::delete('/{id}', [\App\Http\Controllers\CategoryController::class, 'destroy']);
            });
            Route::prefix('genre')->group(function () {
                Route::get('', [\App\Http\Controllers\GenreController::class, 'index']);
                Route::get('/{id}', [\App\Http\Controllers\GenreController::class, 'view']);
                Route::post('/', [\App\Http\Controllers\GenreController::class, 'store']);
                Route::post('/{id}', [\App\Http\Controllers\GenreController::class, 'update']);
                Route::delete('/{id}', [\App\Http\Controllers\GenreController::class, 'destroy']);
            });
            Route::prefix('tag')->group(function () {
                Route::get('', [\App\Http\Controllers\TagController::class, 'index']);
                Route::get('/{id}', [\App\Http\Controllers\TagController::class, 'view']);
                Route::post('/', [\App\Http\Controllers\TagController::class, 'store']);
                Route::post('/{id}', [\App\Http\Controllers\TagController::class, 'update']);
                Route::delete('/{id}', [\App\Http\Controllers\TagController::class, 'destroy']);
            });
            Route::prefix('user')->group(function () {
                Route::get('', [\App\Http\Controllers\UserController::class, 'index']);
                Route::get('/{id}', [\App\Http\Controllers\UserController::class, 'view']);
                Route::post('/', [\App\Http\Controllers\UserController::class, 'store']);
                Route::post('/{id}', [\App\Http\Controllers\UserController::class, 'update']);
                Route::delete('/{id}', [\App\Http\Controllers\UserController::class, 'destroy']);
            });
            Route::prefix('location')->group(function () {
                Route::get('', [\App\Http\Controllers\LocationController::class, 'index']);
                Route::post('', [\App\Http\Controllers\LocationController::class, 'store']);
                Route::post('/{location}/books', [\App\Http\Controllers\LocationController::class, 'addBooksToLocation']);
                Route::get('/{location}/books', [\App\Http\Controllers\LocationController::class, 'getBooksInLocation']);
                Route::delete('/{location}/books/{id}', [\App\Http\Controllers\LocationController::class, 'removeBookFromLocation']);
                Route::get('/{id}', [\App\Http\Controllers\LocationController::class, 'view']);
                Route::post('/{id}', [\App\Http\Controllers\LocationController::class, 'edit']);
                Route::delete('/{id}', [\App\Http\Controllers\LocationController::class, 'delete']);
            });
        });
    });
});
