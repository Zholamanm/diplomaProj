<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use App\Models\Genre;
use App\Models\Location;
use App\Models\Role;
use App\Models\Slider;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CommonController extends Controller
{
    protected $quoteService;

    public function index()
    {
        $categories = Cache::remember('categories', 60 * 24, function () {
            return Category::all();
        });

        $genres = Cache::remember('genres', 60 * 24, function () {
            return Genre::all();
        });

        $tags = Cache::remember('tags', 60 * 24, function () {
            return Tag::all();
        });

        $roles = Cache::remember('roles', 60 * 24, function () {
            return Role::all();
        });

        $sliders = Cache::remember('sliders', 60 * 24, function () {
            return Slider::all();
        });

        $books = Cache::remember('books', 60 * 24, function () {
            return Book::all()->count();
        });

        $users = Cache::remember('users', 60 * 24, function () {
            return User::all()->count();
        });

        $locations = Cache::remember('locations', 60 * 24, function () {
            return Location::all()->count();
        });

        return [
            'categories' => $categories,
            'genres' => $genres,
            'tags' => $tags,
            'roles' => $roles,
            'sliders' => $sliders,
            'stats' => [
                'books' => $books,
                'users' => $users,
                'locations' => $locations,
            ]
        ];
    }
}
