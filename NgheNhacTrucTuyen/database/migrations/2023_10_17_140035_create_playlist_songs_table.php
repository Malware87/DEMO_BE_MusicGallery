<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // Trong tệp migration cho bảng Playlist_Songs
    public function up()
    {
        Schema::create('playlist_songs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('playlist_id')->constrained();
            $table->foreignId('song_id')->constrained();
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('playlist_songs');
    }
};
