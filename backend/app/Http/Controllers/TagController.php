<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function index(Request $request)
    {
        return Tag::orderBy('id', 'DESC')->filter($request->all())->paginate(20);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
        ]);

        Tag::create([
            'name' => $validated['name'],
        ]);

        return ['success' => true];
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string',
        ]);

        $tag = Tag::where('id', $id)->first();
        $tag->name = $validated['name'];
        $tag->save();

        return ['success' => true];
    }

    public function view($id)
    {
        return Tag::where('id', $id)->first();
    }

    public function destroy($id)
    {
        Tag::find($id)->delete();
        return ['success' => true];
    }
}
