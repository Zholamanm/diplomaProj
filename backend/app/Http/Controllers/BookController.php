<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    public function index(Request $request)
    {
        return Book::orderBy('id', 'DESC')->filter($request->all())->paginate(20);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'author' => 'required|string',
            'description' => 'required|string',
            'category_id' => 'nullable',
            'tags_id' => 'nullable|array',
        ]);

        Book::create([
            'title' => $validated['title'],
            'author' => $validated['author'],
            'description' => $validated['description'],
        ]);

        return ['success' => true];
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'author' => 'required|string',
            'description' => 'required|string'
        ]);

        $book = Book::where('id', $id)->first();
        $book->title = $validated['title'];
        $book->author = $validated['author'];
        $book->description = $validated['description'];
        $book->save();

        return ['success' => true];
    }

    public function view($id)
    {
        return Book::where('id', $id)->first();
    }

    public function destroy($id)
    {
        Book::find($id)->delete();
        return ['success' => true];
    }
}
