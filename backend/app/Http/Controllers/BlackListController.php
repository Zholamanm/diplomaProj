<?php

namespace App\Http\Controllers;

use App\Models\BlackList;
use Illuminate\Http\Request;

class BlackListController extends Controller
{
    public function index(Request $request)
    {
        return BlackList::with('user')->orderBy('id', 'DESC')->filter($request->all())->paginate(20);
    }
}
