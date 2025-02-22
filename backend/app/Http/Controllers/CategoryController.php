<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        return Category::orderBy('id', 'DESC')->filter($request->all())->paginate(20);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
        ]);

        Category::create([
            'name' => $validated['name'],
        ]);

        return ['success' => true];
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string',
        ]);

        $category = Category::where('id', $id)->first();
        $category->name = $validated['name'];
        $category->save();

        return ['success' => true];
    }

    public function view($id)
    {
        return Category::where('id', $id)->first();
    }

    public function destroy($id)
    {
        Category::find($id)->delete();
        return ['success' => true];
    }
}
