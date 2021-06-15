<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/external-books', [BookController::class, 'index']);

Route::group(['prefix' => 'v1'], function(){
    // ------------------Create New Book ------------------------------
      Route::post('/books',[BookController::class, 'create']);
      Route::get('/books',[BookController::class, 'read']);
      Route::patch('/books/{id}', [BookController::class, 'update']);
      Route::delete('/books/{id}', [BookController::class, 'delete']);
      Route::post('/books/{id}/delete', [BookController::class, 'delete']);

});