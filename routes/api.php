<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;





use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\ReviewController;
///////all api 's related with authenticated users (admin-investor)
///
Route::prefix('user')->group(function () {


    Route::post('/users/register', [AuthController::class, 'register']);
    Route::post('/users/login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('/reviews', [ReviewController::class, 'index']);
    Route::put('/reviews/{id}', [ReviewController::class, 'markReview']);
    Route::delete('/reviews/{id}', [ReviewController::class, 'delete']);
});

//
//Route::middleware(['auth:sanctum'])->prefix('')->group(function () {
//
//
//    Route::get('/notifications',[,'getNotifications']);
//    Route::Put('/notifications/{id}/read',[,'markNotififcation']);
//
//
//
//});

///////all api 's related with admin


Route::middleware(['auth:sanctum', 'admin'])->prefix('managing-library')->group(function () {

    // Existing admin route for assigning roles
    Route::resource('/books', BookController::class);
    Route::resource('/authors', AuthorController::class);
    Route::delete('/reviews/{id}', [ReviewController::class, 'delete']);
});




Route::group(['middleware' => ['auth.api']], function () {

    Route::get('/users/profile', [AuthController::class, 'show']);
    Route::put('/users/profile', [AuthController::class, 'update']);
    Route::get('/books/{id}', [BookController::class, 'show']);
    Route::get('/books', [BookController::class, 'index']);
    Route::get('/authors', [AuthorController::class, 'show']);
    Route::get('/authors', [AuthorController::class, 'index']);
    Route::Post('/reviews/books/{book_id}',[ReviewController::class,'addReviewToBook']);
    Route::Post('/reviews/authors/{author_id}',[ReviewController::class,'addReviewToAuthor']);

});
