<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('genres', function (Blueprint $table) {
            $table->string('urlPic')->nullable();
        });
    }

    public function down()
    {
        Schema::table('genres', function (Blueprint $table) {
            $table->dropColumn('urlPic');
        });
    }
};
