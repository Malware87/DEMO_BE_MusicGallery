<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\PlaylistSong;

class PlaylistSongController extends Controller {
    //Thêm bài hát vào danh sách phát
    public function addSongToPlaylist(Request $request) {
        $playlistId = $request->input('playlist_id');
        $songId = $request->input('song_id');
        $order = $request->input('order');

        $playlistSong = PlaylistSong::create([
            'playlist_id' => $playlistId,
            'song_id' => $songId,
            'order' => $order,
        ]);

        return response()->json(['message' => 'Bài hát đã được thêm vào danh sách phát', 'playlist_song' => $playlistSong], 200);
    }
    // Cập nhật thứ tự bài hát trong danh sách phát
    public function updateSongOrderInPlaylist(Request $request, $playlistSongId) {
        $order = $request->input('order');

        $playlistSong = PlaylistSong::find($playlistSongId);

        if (!$playlistSong) {
            return response()->json(['message' => 'Playlist song not found'], 404);
        }

        $playlistSong->update([
            'order' => $order,
        ]);

        return response()->json(['message' => 'Thứ tự bài hát trong danh sách phát được cập nhật thành công', 'playlist_song' => $playlistSong], 200);
    }
    // Xóa bài hát khỏi danh sách phát
    public function removeSongFromPlaylist(Request $request, $playlistSongId) {
        $playlistSong = PlaylistSong::find($playlistSongId);

        if (!$playlistSong) {
            return response()->json(['message' => 'Playlist-song không tồn tại'], 404);
        }

        $playlistSong->delete();

        return response()->json(['message' => 'Bài hát đã được xóa khỏi danh sách phát'], 200);
    }
}
