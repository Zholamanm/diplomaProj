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

        $book = Book::create([
            'title' => $validated['title'],
            'author' => $validated['author'],
            'description' => $validated['description'],
            'category_id' => $validated['category_id']
        ]);

        if (!empty($validated['tags_id'])) {
            $book->tags()->sync($validated['tags_id']);
        }

        return ['success' => true];
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title'    => 'required|string',
            'author'   => 'required|string',
            'description' => 'required|string',
            'category_id' => 'nullable',
            'tags_id'  => 'nullable|array',
        ]);

        $book = Book::findOrFail($id);

        $book->update([
            'title'       => $validated['title'],
            'author'      => $validated['author'],
            'description' => $validated['description'],
            'category_id' => $validated['category_id'],
        ]);

        if (array_key_exists('tags_id', $validated)) {
            $book->tags()->sync($validated['tags_id']);
        } else {
            $book->tags()->sync([]);
        }
        return ['success' => true];
    }

    public function view($id)
    {
        return Book::where('id', $id)->with('tags')->first();
    }

    public function destroy($id)
    {
        Book::find($id)->delete();
        return ['success' => true];
    }
}
