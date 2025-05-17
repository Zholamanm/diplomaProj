<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Role;
use App\Models\Tag;
use App\Services\QuoteService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CommonController extends Controller
{
    protected $quoteService;

    public function __construct(QuoteService $quoteService)
    {
        $this->quoteService = $quoteService;
    }

    public function index()
    {
        $categories = Cache::remember('categories', 60 * 24, function () {
            return Category::all();
        });

        $tags = Cache::remember('tags', 60 * 24, function () {
            return Tag::all();
        });

        $roles = Cache::remember('roles', 60 * 24, function () {
            return Role::all();
        });

        $quote = Cache::remember('random_quote', 60, function () {
            return $this->quoteService->getRandomQuote();
        });

        return [
            'categories' => $categories,
            'tags' => $tags,
            'roles' => $roles,
            'quote' => $quote,
        ];
    }
}
