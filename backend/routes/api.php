<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
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

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:api')->post('/logout', [AuthController::class, 'logout']);
Route::middleware('auth:api')->get('/user-info', function (Request $request) {
    return $request->user();
});
Route::get('books', [\App\Http\Controllers\ClientController::class, 'getBooks']);
Route::get('books/{id}', [\App\Http\Controllers\ClientController::class, 'getBookById']);
Route::get('book/locations/{id}/', [\App\Http\Controllers\ClientController::class, 'getLocations']);
Route::get('locations/{id}', [\App\Http\Controllers\ClientController::class, 'getLocationById']);

Route::middleware(['auth:api'])->group(function () {
    Route::post('books/{id}/borrow', [\App\Http\Controllers\ClientController::class, 'borrow']);
    Route::post('/locations', [\App\Http\Controllers\ClientController::class, 'borrow']);

    Route::middleware(['admin_routes'])->group(function () {
// role:1 - Admin
// role:2 - Librarian
// role:3 - Member

        Route::middleware('role:1,2')->group(function () {
            Route::prefix('book')->group(function () {
                Route::get('', [\App\Http\Controllers\BookController::class, 'index']);
                Route::get('/{id}', [\App\Http\Controllers\BookController::class, 'view']);
                Route::post('/', [\App\Http\Controllers\BookController::class, 'store']);
                Route::post('/{id}', [\App\Http\Controllers\BookController::class, 'update']);
                Route::delete('/{id}', [\App\Http\Controllers\BookController::class, 'destroy']);
            });
            Route::prefix('category')->group(function () {
                Route::get('', [\App\Http\Controllers\CategoryController::class, 'index']);
                Route::get('/{id}', [\App\Http\Controllers\CategoryController::class, 'view']);
                Route::post('/', [\App\Http\Controllers\CategoryController::class, 'store']);
                Route::post('/{id}', [\App\Http\Controllers\CategoryController::class, 'update']);
                Route::delete('/{id}', [\App\Http\Controllers\CategoryController::class, 'destroy']);
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
                Route::get('/{location}/books/{id}', [\App\Http\Controllers\LocationController::class, 'removeBookFromLocation']);
                Route::get('/{id}', [\App\Http\Controllers\LocationController::class, 'view']);
                Route::post('/{id}', [\App\Http\Controllers\LocationController::class, 'edit']);
                Route::delete('/{id}', [\App\Http\Controllers\LocationController::class, 'delete']);
            });
        });
    });
});
