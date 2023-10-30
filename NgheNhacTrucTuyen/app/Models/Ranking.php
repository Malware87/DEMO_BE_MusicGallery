<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ranking extends Model
{
    protected $fillable = ['song_id', 'listen_count', 'average_rating'];

    // Định nghĩa mối quan hệ giữa Ranking và Song
    public function song()
    {
        return $this->belongsTo(Song::class);
    }
}
