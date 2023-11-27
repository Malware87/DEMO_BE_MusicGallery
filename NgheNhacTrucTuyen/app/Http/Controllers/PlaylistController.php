<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Playlist;

class PlaylistController extends Controller {
    // Tạo mới playlist
    public function createPlaylist(Request $request) {
        $name = $request->input('name');
        $description = $request->input('description');

        $playlist = Playlist::create([
            'name' => $name,
            'description' => $description,
        ]);

        return response()->json(['message' => 'Playlist được tạo thành công', 'playlist' => $playlist], 200);
    }
    // Cập nhật playlist
    public function updatePlaylist(Request $request, $playlistId) {
        $name = $request->input('name');
        $description = $request->input('description');

        $playlist = Playlist::find($playlistId);

        if (!$playlist) {
            return response()->json(['message' => 'Playlist không tồn tại'], 404);
        }

        $playlist->update([
            'name' => $name,
            'description' => $description,
        ]);

        return response()->json(['message' => 'Playlist đã được cập nhật thành công', 'playlist' => $playlist], 200);
    }
    // Xóa playlist
    public function deletePlaylist(Request $request, $playlistId) {
        $playlist = Playlist::find($playlistId);

        if (!$playlist) {
            return response()->json(['message' => 'Playlist không tồn tại'], 404);
        }
        $playlist->delete();
        return response()->json(['message' => 'Playlist đã được xóa thành công'], 200);
    }
    // Lấy toàn bộ danh sách playlist
    public function getAllPlaylists(Request $request) {
        $playlists = Playlist::select('id', 'name', 'description')->get();

        return response()->json(['playlists' => $playlists], 200);
    }
    // Lấy các bài hát trong playlist
    public function getSongsInPlaylist(Request $request, $playlistId) {
        $playlist = Playlist::find($playlistId);

        if (!$playlist) {
            return response()->json(['message' => 'Playlist not found'], 404);
        }

        $songs = $playlist->songs()->select('id', 'title', 'singerID', 'genre', 'file_path', 'lyrics', 'listen_count', 'rating')->get();

        return response()->json(['songs' => $songs], 200);
    }
}
