<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\NotesController;
use App\Http\Controllers\API\MoviesController;
use App\Http\Controllers\API\FavoritesController;
use App\Http\Controllers\API\CommentController;
use App\Http\Controllers\API\FavoritesapiController;

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

Route::get('users',[AuthController::class,'indexUser']);
Route::post('login', [AuthController::class, 'signin']);
Route::post('register', [AuthController::class, 'signup']);

Route::delete('destroyUser/{id}',[AuthController::class,'destroyUser']);
Route::put('users/updatei/{id}', [AuthController::class, 'updatei']);
Route::put('users/updateadmin/{id}', [AuthController::class, 'updateadmin']);
Route::put('users/updatep/{id}', [AuthController::class, 'updatep']);

Route::get('movies',[MoviesController::class,'index']);
Route::get('movies/{id}',[MoviesController::class,'show']);
Route::post('storemovie', [MoviesController::class, 'store']);
Route::put('updatemovie/{id}', [MoviesController::class, 'update']);
Route::delete('deletemovie/{id}', [MoviesController::class, 'destroy']);

Route::get('favorites/{id}',[FavoritesController::class,'index']);
Route::get('favorites',[FavoritesController::class,'indexall']);
Route::post('addfavorite',[FavoritesController::class,'store']);
Route::delete('destroyfav/{id}',[FavoritesController::class,'destroy']);

Route::get('favoritesapi/{id}',[FavoritesapiController::class,'index']);
Route::post('addfavoriteapi',[FavoritesapiController::class,'store']);
Route::delete('destroyfavapi/{id}',[FavoritesapiController::class,'destroy']);

Route::get('notes',[NotesController::class,'index']);
Route::post('addnote',[NotesController::class,'store']);
Route::put('updatenote/{id}', [NotesController::class, 'update']);

Route::get('getcomments', [CommentController::class, 'index']);
Route::get('getcomments/{id}',[CommentController::class,'comments']);
Route::get('comments/{id}', [CommentController::class, 'show']);
Route::post('postcomments/{id}',[CommentController::class,'store']);
Route::put('comments/{id}',[CommentController::class,'comments']);
Route::delete('comments/{id}', [CommentController::class, 'destroy']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
