<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Playlist;

class PlaylistController extends Controller {

    // Tạo mới playlist
    public function createPlaylist(Request $request) {
        $data = $request->only('user_id', 'name', 'description');
        Playlist::create($data);
        return response()->json(['message' => 'Playlist được tạo thành công'], 201);
    }

    // Cập nhật playlist
    public function updatePlaylist(Request $request) {
        $playlistID = $request->input('id');
        $data = $request->only('name', 'description');
        $dataToKeep = array_filter($data, function ($value) {
            return $value !== null && $value !== '';
        });
        $playlist = Playlist::find($playlistID);
        if (!$playlist) {
            return response()->json(['message' => 'Playlist không tồn tại'], 400);
        }
        Playlist::where('id', $playlistID)->update($dataToKeep);
        return response()->json(['message' => 'Playlist đã được cập nhật thành công'], 200);
    }

    // Xóa playlist
    public function deletePlaylist(Request $request) {
        $playlistID = $request->input('id');
        $playlist = Playlist::find($playlistID);
        if (!$playlist) {
            return response()->json(['message' => 'Playlist không tồn tại'], 404);
        }
        Playlist::where('id', $playlistID)->delete();
        return response()->json(['message' => 'Playlist đã được xóa thành công'], 200);
    }

    // Lấy toàn bộ danh sách playlist
    public function getAllPlaylists(Request $request) {
        $id = $request->input('user_id');
        $playlists = Playlist::where('user_id', $id)->select('id', 'name', 'description')->get();
        return response()->json($playlists);
    }
}
