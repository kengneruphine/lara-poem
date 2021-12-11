<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PoemController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Public routes

//User routes
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

//Poem routes
Route::get('poems', [PoemController::class, 'index']);
Route::get('poems/{id}', [PoemController::class, 'show']);
Route::post('poems/search', [PoemController::class, 'search']);

// Protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    //    User routes
    Route::get('users', [AuthController::class, 'index']);
    Route::post('logout', [AuthController::class, 'logout']);

    //    Poems routes
    Route::post('poem', [PoemController::class, 'store']);
    Route::post('poem/like', [PoemController::class, 'like']);
    Route::post('poem/dislike', [PoemController::class, 'dislike']);
    Route::put('poems/{id}', [PoemController::class, 'update']);
    Route::delete('poems/{id}', [PoemController::class, 'destroy']);

    //    Comments routes
    Route::get('comments', [CommentController::class, 'index']);
    Route::get('comments/{id}', [CommentController::class, 'show']);
    Route::post('comments', [CommentController::class, 'store']);
    Route::put('comments/{id}', [CommentController::class, 'update']);
    Route::delete('comments/{id}', [CommentController::class, 'destroy']);

    //    Likes routes
    Route::get('likes', [LikeController::class, 'index']);
    Route::get('likes/{id}', [LikeController::class, 'show']);
    Route::put('likes/{id}', [LikeController::class, 'update']);
    Route::delete('likes/{id}', [LikeController::class, 'destroy']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});