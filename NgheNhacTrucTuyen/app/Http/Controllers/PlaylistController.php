<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Playlist;

class PlaylistController extends Controller {
    //
    public function NewPlaylist(Request $request) {
        $name = $request->input('name');
        $description = $request->input('description');
        $id = $request->input('userId');
        Playlist::create(['name' => $name, 'description' => $description, 'user_id' => $id]);
        return response()->json(['message' => 'Created'], 201);
    }

    public function GetPlaylist(Request $request) {
        $id = $request->input('userID');
        $playlist = Playlist::where('user_id', $id)->select('name', 'description')->get();
        return response()->json($playlist);
    }
}
