<?php

namespace App\Http\Controllers;

use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Song;
use Illuminate\Support\Str;

class SongController extends Controller {
    public function AddSong(Request $request) {
        if ($request->hasFile('audio')) {
            $title = ucwords(Str::lower($request->input('title')));
            $song = Song::where('title', $title)->first();
            if ($song) {
                return response()->json(['message' => 'Song already uploaded'], 401);
            }
            $artist = ucwords(Str::lower($request->input('artist')));
            $genre = $request->input('genre');
            $lyrics = $request->input('lyrics');
            $file = $request->file('audio');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads'), $fileName);
            $filePath = public_path('uploads') . DIRECTORY_SEPARATOR . $fileName;
            // $filePath = $request->file('audio')->storeAs('uploads', time() . '_' . $request->file('audio')->getClientOriginalName(), 'public');
            Song::create(['title' => $title, 'artist' => $artist, 'genre' => $genre, 'file_path' => $filePath, 'lyrics' => $lyrics]);
            return response()->json(['message' => 'Upload successfully'], 200);
        }
    }
}
