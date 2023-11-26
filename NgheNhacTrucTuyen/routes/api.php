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
Route::post('/user/getuser', [UserController::class, 'GetUser']);
Route::post('/login', [UserController::class, 'Login']);
Route::post('/user/register', [UserController::class, 'Register']);
Route::post('/user/forgot', [UserController::class, 'Forgot']);
Route::post('/user/changepwd', [UserController::class, 'ChangePwd']);
Route::delete('/user', [UserController::class, 'DeleteUser']);
Route::post('/user/update', [UserController::class, 'UpdateUser']);

// Songs routes
Route::post('/song/addsong', [SongController::class, 'AddSong']);
Route::post('/song/search', [SongController::class, 'Search']);
Route::post('/song/getsong', [SongController::class, 'GetSong']);

Route::get('/user/{id}', [UserController::class, 'GetUserById']);

// Genre routes
Route::get('/genre/getgenre', [GenreController::class, 'GetGenre']);
