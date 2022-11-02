<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        return Book::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            "title" => ['required', 'string']
        ]);

        $book = Book::create([
            "title" => $request->title
        ]);

        return $book;
    }

    public function show(Book $book)
    {
        return $book;
    }

    public function update(Request $request, Book $book)
    {
        $request->validate([
            "title" => ["required", "string"]
        ]);

        $book->update([
            "title" => $request->title
        ]);

        return $book;
    }

    public function destroy(Book $book)
    {
        $book->delete();

        return response()->noContent();
    }
}
