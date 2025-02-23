<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
            'cover_image' => 'nullable|file|mimes:jpg,png,jpeg,gif|max:2048',
        ]);

        $book = Book::create([
            'title' => $validated['title'],
            'author' => $validated['author'],
            'description' => $validated['description'],
            'category_id' => $validated['category_id']
        ]);

        if ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->store('covers', 'public');
            $book->cover_image = $path;
            $book->save();
        }

        if (!empty($validated['tags_id'])) {
            $book->tags()->sync($validated['tags_id']);
        }

        return ['success' => true];
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title'       => 'required|string',
            'author'      => 'required|string',
            'description' => 'required|string',
            'category_id' => 'nullable',
            'tags_id'     => 'nullable|array',
            'cover_image' => 'sometimes|nullable|file|image|max:2048',
        ]);

        $book = Book::findOrFail($id);
        $book->title       = $validated['title'];
        $book->author      = $validated['author'];
        $book->description = $validated['description'];
        $book->category_id = $validated['category_id'];

        if ($request->hasFile('cover_image')) {
             if ($book->cover_image && Storage::disk('public')->exists($book->cover_image)) {
                 Storage::disk('public')->delete($book->cover_image);
             }

            $path = $request->file('cover_image')->store('books', 'public');
            $book->cover_image = $path;
        }

        $book->save();

        // Sync tags: if tags_id is provided, update the pivot table accordingly;
        // otherwise, you can choose to clear existing tags.
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
