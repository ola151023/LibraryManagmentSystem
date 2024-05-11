<?php

namespace App\Http\Controllers;

use App\Helpers\CustomHelpers;
use App\Http\Requests\AuthorRequest;
use App\Models\Author;
use App\Models\Book;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $cacheKey = 'authors';

        // Check if data is cached
        if (Cache::has($cacheKey)) {

            // If cached, return cached data
            return Cache::get($cacheKey);
        }

        $authors=Author::all();
        Log::info($authors);
       CustomHelpers::cacheData($cacheKey, $authors->toArray(), 3600);

        return $authors;


    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AuthorRequest $request)
    {
        $author= Author::create([
            'name' => $request->name,
            'biography' => $request->biography,

        ]);

        return response()->json([
            'message' => 'author added successfully',
            'data'=>$author]
            , 201);

    }

    /**
     * Display the specified resource.
     */
    public function show( $authorId)
    {
        $author=Author::findOrFail($authorId);
        return $author;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Author $author)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Author $author)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Author $author)
    {

        $author=Author::findOrFail($author);
        $author->delete();
        return response()->json(null,204);


    }
}
