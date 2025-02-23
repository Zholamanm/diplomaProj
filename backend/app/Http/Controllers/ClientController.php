<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function getBooks(Request $request)
    {
        return Book::orderBy('id', 'DESC')->filter($request->all())->paginate(20);
    }
}
