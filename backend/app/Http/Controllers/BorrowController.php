<?php

namespace App\Http\Controllers;

use App\Models\BorrowedBook;
use Illuminate\Http\Request;

class BorrowController extends Controller
{
    public function get()
    {
        return BorrowedBook::all();
    }
}
