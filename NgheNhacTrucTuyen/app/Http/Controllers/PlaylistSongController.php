<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\PlaylistSong;

class PlaylistSongController extends Controller {
    //Thêm bài hát vào danh sách phát
    public function addSongToPlaylist(Request $request) {
        $data = $request->only('playlist_id', 'song_id');
        PlaylistSong::create($data);
        return response()->json(['message' => 'Bài hát đã được thêm vào danh sách phát'], 200);
    }

    // Cập nhật thứ tự bài hát trong danh sách phát
    public function updateSongOrderInPlaylist(Request $request, $playlistSongId) {
        $order = $request->input('order');

        $playlistSong = PlaylistSong::find($playlistSongId);

        if (!$playlistSong) {
            return response()->json(['message' => 'Playlist song not found'], 404);
        }

        $playlistSong->update(['order' => $order,]);

        return response()->json(['message' => 'Thứ tự bài hát trong danh sách phát được cập nhật thành công', 'playlist_song' => $playlistSong], 200);
    }

    // Xóa bài hát khỏi danh sách phát
    public function removeSongFromPlaylist(Request $request) {
        $playlistID = $request->input('playlist_id');
        $songID = $request->input('song_id');
        $playlistSong = PlaylistSong::where('playlist_id', $playlistID)->andWhere('song_id', $songID)->first();
        if (!$playlistSong) {
            return response()->json(['message' => 'Playlist-song không tồn tại'], 404);
        }
        PlaylistSong::where('playlist_id', $playlistID)->andWhere('song_id', $songID)->delete();
        return response()->json(['message' => 'Song deleted from playlist'], 200);
    }

    public function GetSongFromPlaylist(Request $request) {
        $id = $request->input('playlist_id');
        $playlist = PlaylistSong::where('playlist_id', $id)->select('song_id')->get();
        if (!$playlist) {
            return response()->json(['message' => 'Playlist not found'], 404);
        }

        return response()->json($playlist);
    }
}
