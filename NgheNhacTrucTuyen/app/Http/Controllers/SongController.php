<?php

namespace App\Http\Controllers;

use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Song;
use App\Models\Singer;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

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
            $file->move(public_path('uploads/audio'), $fileName);
            $publicFolder = 'uploads';
            $filePath = DIRECTORY_SEPARATOR . $publicFolder . DIRECTORY_SEPARATOR . 'audio' . DIRECTORY_SEPARATOR . $fileName;
            // $filePath = $request->file('audio')->storeAs('uploads', time() . '_' . $request->file('audio')->getClientOriginalName(), 'public');
            Song::create(['title' => $title, 'singerID' => $artist, 'genre' => $genre, 'file_path' => $filePath, 'lyrics' => $lyrics]);
            return response()->json(['message' => 'Upload successfully'], 200);
        }
    }

    public function Search(Request $request) {
        if ($request->has('title')) {
            $entry = $request->input('title');
            $searchResult = Song::where('title', 'LIKE', '%' . $entry . '%')->select('id', 'title', 'singerID', 'genre', 'listen_count', 'rating')->get();
            return response()->json($searchResult);
        }
        if ($request->has('artist')) {
            $entry = $request->input('artist');
            $searchResult = Song::where('singerID', 'LIKE', '%' . $entry . '%')->select('id', 'title', 'singerID', 'genre', 'listen_count', 'rating')->get();
            return response()->json($searchResult);
        }
        if ($request->has('genre')) {
            $entry = $request->input('genre');
            $searchResult = Song::where('genre', 'LIKE', '%' . $entry . '%')->select('id', 'title', 'singerID', 'genre', 'listen_count', 'rating')->get();
            return response()->json($searchResult);
        }
        if ($request->has('start')) {
            $entry = $request->input('start');
            $records = Song::count();
            $searchResult = Song::select('songs.id', 'songs.title as song_name', 'singers.name as singer_name', 'songs.genre', 'songs.listen_count')->join('singers', 'songs.singerID', '=', 'singers.id')->orderBy('songs.id')->skip($entry)->take(10)->get();
            return response()->json(['record' => $records, 'songs' => $searchResult]);
        }
    }

    public function GetSong(Request $request) {
        $entry = $request->input('id');
        $searchResult = Song::where('songs.id', $entry)->select('title', 'singers.name as artist', 'singerID', 'genre', 'file_path', 'lyrics', 'listen_count', 'rating')->join('singers', 'songs.singerID', '=', 'singers.id')->first();
        Song::where('id', $entry)->update(['listen_count' => $searchResult->listen_count + 1]);
        return response()->json($searchResult);
    }

    public function GetTopSongs(Request $request) {
        $many = $request->input('many');
        $topSongs = Song::select('songs.id', 'songs.title as song_name', 'singerID', 'singers.name as singer_name', 'songs.genre', 'songs.listen_count', 'file_path')->join('singers', 'songs.singerID', '=', 'singers.id')->orderBy('listen_count', 'desc')->take($many)->get();
        return response()->json($topSongs);
    }

    public function GetSongFromPlaylist(Request $request) {
        $playlist_id = $request->input('playlist_id');
        $songsInPlaylist = Song::select('songs.id', 'songs.title as song_name', 'singers.name as singer_name')->join('playlist_songs', 'songs.id', '=', 'playlist_songs.song_id')->join('singers', 'songs.singerID', '=', 'singers.id')->where('playlist_songs.playlist_id', $playlist_id)->get();
        return response()->json(['list' => $songsInPlaylist, 'count' => $songsInPlaylist->count()]);
    }


    public function searchSongsBySinger(Request $request) {
        $singerID = $request->input('singerID');
        // Kiểm tra xem ca sĩ có tồn tại hay không
        $singer = Singer::find($singerID);
        if (!$singer) {
            return response()->json(['message' => 'Ca sĩ không tồn tại'], 404);
        }
        // Lấy danh sách các bài hát của ca sĩ
        $songs = $singer->songs;
        return response()->json($songs);
    }

    public function DeleteSong(Request $request) {
        $id = $request->input('id');
        $song = Song::find($id);
        if ($song) {
            File::delete($song->file_path);
            Song::where('id', $id)->delete();
            return response()->json(['message' => 'cook well']);
        } else {
            return response()->json(['message' => 'can not cook'], 401);
        }
    }

    public function SearchBar(Request $request) {
        $entry = $request->input('entry');
        $song = Song::where('title', 'LIKE', '%' . $entry . '%')->get();
        $artist = Singer::where('name', 'LIKE', '%' . $entry . '%')->get();
        return response()->json(['song' => $song, 'artist' => $artist]);
    }
}

