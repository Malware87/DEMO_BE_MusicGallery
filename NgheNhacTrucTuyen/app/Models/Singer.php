<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Singer extends Model
{
    use HasFactory;
    protected $fillable = ['urlAvatar', 'name', 'singerDescription'];

    // Singer.php (Model)
    public function songs()
    {
        return $this->hasMany(Song::class, 'singerID');
    }
    public function getTotalListenCount()
    {
        // Sử dụng eloquent để lấy tổng listen_count của tất cả bài hát của ca sĩ
        return $this->songs()->sum('listen_count');
    }
}
