<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model {
    protected $fillable = ['username', 'password', 'email', 'avatar', 'registered_at', 'role',];

    // Định nghĩa mối quan hệ giữa User và Playlists
    public function playlists() {
        return $this->hasMany(Playlist::class);
    }
}
