<?php

namespace App\Http\Controllers;

use App\Models\BlackList;
use App\Models\BorrowedBook;
use Illuminate\Http\Request;

class BorrowController extends Controller
{
    public function get()
    {
        return BorrowedBook::all();
    }

    public function index(Request $request)
    {
        return BorrowedBook::with('book', 'location', 'user')->orderBy('id', 'DESC')->filter($request->all())->paginate(20);
    }

    public function checkout(Request $request)
    {
        $borrow = BorrowedBook::where('id', $request->borrow_id)->first();
        if (!$borrow) {
            return response()->json([
                'success' => false,
                'message' => 'Borrowed book not found.'
            ], 404);
        }

        $borrow->status = $request->status;
        $borrow->received_at = now();
        $borrow->save();

        return response()->json([
            'success' => true
        ]);
    }

    public function returnBook(Request $request)
    {
        $borrow = BorrowedBook::where('id', $request->borrow_id)->first();
        if (!$borrow) {
            return response()->json([
                'success' => false,
                'message' => 'Borrowed book not found.'
            ], 404);
        }

        if(now() > $borrow->due_date) {
            $blackList = BlackList::where('user_id', $borrow->user_id)->first();
            if($blackList) {
                $blackList->violation_count += 1;
                $isThirdViolation = ($blackList->violation_count == 3);
                if ($isThirdViolation) {
                    $blackList->start_date = now();
                    $blackList->expire_date = now()->addWeeks(5);
                }
                $blackList->save();
            } else {
                BlackList::create([
                    'user_id' => $borrow->user_id,
                    'violation_count' => 1
                ]);
            }
        }

        $borrow->status = $request->status;
        $borrow->received_at = now();
        $borrow->save();

        return response()->json([
            'success' => true
        ]);
    }
}
