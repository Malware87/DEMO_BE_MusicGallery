<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    protected $fillable = ['name', 'description'];

    // Định nghĩa mối quan hệ giữa Genre và Songs
    public function songs()
    {
        return $this->hasMany(Song::class);
    }
}
