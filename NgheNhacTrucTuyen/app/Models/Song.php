<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    protected $fillable = [
        'title', 'artist', 'genre', 'file_path', 'lyrics', 'listen_count', 'rating',
    ];

    // Định nghĩa mối quan hệ giữa Song và Playlists
    public function playlists()
    {
        return $this->belongsToMany(Playlist::class, 'playlist_songs', 'song_id', 'playlist_id')->withPivot('order');
    }

    // Định nghĩa mối quan hệ giữa Song và Rankings
    public function ranking()
    {
        return $this->hasOne(Ranking::class);
    }
}
