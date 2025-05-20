<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    public function index(Request $request)
    {
        return Genre::orderBy('id', 'DESC')->filter($request->all())->paginate(20);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'category_id' => 'nullable',
        ]);

        Genre::create([
            'name' => $validated['name'],
            'category_id' => $validated['category_id'],
        ]);

        return ['success' => true];
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'category_id' => 'nullable',
        ]);

        $genre = Genre::where('id', $id)->first();
        $genre->name = $validated['name'];
        $genre->category_id = $validated['category_id'];
        $genre->save();

        return ['success' => true];
    }

    public function view($id)
    {
        return Genre::where('id', $id)->first();
    }

    public function destroy($id)
    {
        Genre::find($id)->delete();
        return ['success' => true];
    }
}
