<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\SongController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\PlaylistController;
use App\Http\Controllers\PlaylistSongController;
use App\Http\Controllers\RankingController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// User routes

Route::post('/login', [UserController::class, 'Login']);
Route::post('/user/register', [UserController::class, 'Register']);
Route::post('/user/forgot', [UserController::class, 'Forgot']);
Route::post('/user/changepwd', [UserController::class, 'ChangePwd']);

// Songs routes
Route::post('/song/addsong', [SongController::class, 'AddSong']);
ROute::post('/song/search', [SongController::class, 'Search']);

Route::get('/user/{id}', [UserController::class, 'GetUserById']);
