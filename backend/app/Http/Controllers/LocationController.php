<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\LocationBook;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function index()
    {
        return response()->json(Location::all());
    }

    public function addBooksToLocation(Request $request, $locationId)
    {
        $validated = $request->validate([
            'books' => 'required|array',
            'books.*.book_id' => 'exists:books,id',
            'books.*.quantity' => 'required|integer|min:0'
        ]);

        $location = Location::findOrFail($locationId);

        $existingBooks = $location->books()->pluck('location_books.quantity', 'books.id')->toArray();

        $booksData = [];

        foreach ($validated['books'] as $book) {
            $bookId = $book['book_id'];
            $quantity = $book['quantity'];

            if (array_key_exists($bookId, $existingBooks)) {
                $booksData[$bookId] = ['quantity' => $quantity];
            } else {
                $booksData[$bookId] = ['quantity' => $quantity];
            }
        }

        $location->books()->sync($booksData);

        return response()->json(['message' => 'Books added/updated in location successfully']);
    }

    public function getBooksInLocation($locationId) {
        return LocationBook::where('location_id', $locationId)->get();
    }

    public function removeBookFromLocation($locationId, $id) {
        $record = LocationBook::where(['location_id' => $locationId, 'book_id' => $id])->first();
        if ($record) {
            $record->delete();
            return response()->json(['message' => 'Book removed from location']);
        }
        return response()->json(['message' => 'Record not found'], 404);
    }

    public function store(Request $request)
    {
        $location = Location::create([
            'name' => $request->name ?? 'Unnamed Location',
            'latitude' => $request->lat,
            'longitude' => $request->lng,
        ]);

        return response()->json(['message' => 'Location saved!', 'location' => $location]);
    }

    public function edit(Request $request, $id)
    {
        $location = Location::where('id', $id)->first();
        $location->update([
            'name' => $request->name ?? 'Unnamed Location',
            'latitude' => $request->lat,
            'longitude' => $request->lng,
        ]);

        return response()->json(['message' => 'Location saved!', 'location' => $location]);
    }

    public function view($id)
    {
        return Location::where('id', $id)->first();
    }

    public function delete($id)
    {
        Location::destroy($id);
        return response()->json(['message' => 'Location removed!']);
    }
}
