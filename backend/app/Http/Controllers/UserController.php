<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        return User::orderBy('id', 'DESC')->filter($request->all())->paginate(20);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users',
            'password' => 'required|string|min:8',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        return ['success' => true];
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $book = User::where('id', $id)->first();
        $book->name = $validated['name'];
        $book->email = $validated['email'];
        $book->password = Hash::make($validated['password']);
        $book->save();

        return ['success' => true];
    }

    public function view($id)
    {
        return User::where('id', $id)->first();
    }

    public function destroy($id)
    {
        User::find($id)->delete();
        return ['success' => true];
    }
}
