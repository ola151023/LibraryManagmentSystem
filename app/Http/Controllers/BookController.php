<?php

namespace App\Http\Controllers;

use App\Helpers\CustomHelpers;
use App\Http\Requests\BookRequest;
use App\Http\Requests\BookUpdateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\Author;
use App\Models\Book;
use App\Models\Review;
use App\Models\User;
use App\Notifications\BookNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $cacheKey = 'books';

        // Check if data is cached
        if (Cache::has($cacheKey)) {
            // If cached, return cached data
            return Cache::get($cacheKey);
        }

        // If not cached, fetch data from database
        $books = Book::all();
        CustomHelpers::cacheData($cacheKey, $books, 3600);


        return $books;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BookRequest $request)
    {

        $book = Book::create([
            'title' => $request->title,
            'description' => $request->description,
            'genre' => $request->genre,
            'language'=>$request->language,
            'publisher'=>$request->publisher,
            'publication_date'=>$request->publication_date
        ]);
        $users=User::all();
// Inside the method where you add a new book
        Notification::send($users, new BookNotification($book));
        return response()->json(['message' => 'Book added successfully','data'=>$book], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        $book=Author::findOrFail($book);
        return $book;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BookUpdateRequest $request, Book $book)
    {
        $book=Book::findOrFail($book);
        $book->update($request->all());
        return response()->json(['message'=>'book Updated','book' => $book]);

    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {

        $book=Book::findOrFail($book);
        $book->delete();
        return response()->json(null,204);


    }
}
