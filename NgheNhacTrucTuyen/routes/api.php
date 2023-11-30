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
Route::post('/user/adduser', [UserController::class, 'AddUser']);

// Songs routes
Route::post('/song/addsong', [SongController::class, 'AddSong']);
Route::post('/song/search', [SongController::class, 'Search']);
Route::post('/song/getsong', [SongController::class, 'GetSong']);
Route::post('/song/playlist/get', [SongController::class, 'GetSongFromPlaylist']);


// Genre routes
Route::post('/genre', [GenreController::class, 'GetGenre']);
Route::post('/genre/add', [GenreController::class, 'addGenre']);
Route::delete('/genre', [GenreController::class, 'deleteGenre']);
Route::post('/genre/update', [GenreController::class, 'updateGenre']);

//Playlist Route
Route::post('/playlist/newplaylist', [PlaylistController::class, 'createPlaylist']);
Route::post('/playlist/getplaylist', [PlaylistController::class, 'getAllPlaylists']);
Route::post('/playlist/get', [PlaylistController::class, 'GetPlaylistByID']);
Route::post('/playlist/update', [PlaylistController::class, 'updatePlaylist']);
Route::delete('/playlist', [PlaylistController::class, 'deletePlaylist']);

//PlaylistSong Route
Route::delete('/playlist/song', [PlaylistSongController::class, 'removeSongFromPlaylist']);
Route::post('/playlist/song/addsong', [PlaylistSongController::class, 'addSongToPlaylist']);
