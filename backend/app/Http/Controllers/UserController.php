<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function get(Request $request)
    {
        return User::all();
    }

    public function index(Request $request)
    {
        return User::orderBy('id', 'DESC')->filter($request->all())->paginate(20);
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'nullable',
            'role_id' => 'required'
        ]);
        $password = '12345678';

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role_id' => $validated['role_id'],
            'password' => Hash::make($password),
        ]);

        return ['success' => true];
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'nullable',
            'role_id' => 'required'
        ]);

        $user = User::where('id', $id)->first();
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->role_id = $validated['role_id'];
        $user->save();

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
