<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlaylistSong extends Model
{
    protected $fillable = ['playlist_id', 'song_id', 'order'];

    // Mô hình này không chứa dữ liệu riêng lẻ mà chỉ định nghĩa mối quan hệ giữa Playlists và Songs.
}
