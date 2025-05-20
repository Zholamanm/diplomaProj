<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Genre;
use App\Models\Role;
use App\Models\Tag;
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

        return [
            'categories' => $categories,
            'genres' => $genres,
            'tags' => $tags,
            'roles' => $roles,
        ];
    }
}
