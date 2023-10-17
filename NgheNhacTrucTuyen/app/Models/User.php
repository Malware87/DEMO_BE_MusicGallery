<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $fillable = [
        'username', 'password', 'email', 'registered_at', 'access_role',
    ];

    // Định nghĩa mối quan hệ giữa User và Playlists
    public function playlists()
    {
        return $this->hasMany(Playlist::class);
    }
}
