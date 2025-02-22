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

Route::middleware(['auth:api'])->group(function () {
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
        });
    });
});
