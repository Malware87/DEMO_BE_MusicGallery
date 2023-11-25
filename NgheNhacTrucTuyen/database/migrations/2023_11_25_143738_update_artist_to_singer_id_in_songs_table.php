<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('songs', function (Blueprint $table) {
            $table->dropColumn('artist'); // Xóa trường cũ
            $table->unsignedBigInteger('singerID'); // Thêm trường mới

            // Tạo khóa ngoại liên kết với bảng singers
            $table->foreign('singerID')->references('id')->on('singers');

            // Cập nhật trường singerID từ dữ liệu cũ (nếu cần)
            // $table->update(['singerID' => ...]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('songs', function (Blueprint $table) {
            $table->dropForeign(['singerID']); // Xóa khóa ngoại
            $table->dropColumn('singerID'); // Xóa trường mới
            $table->string('artist'); // Thêm lại trường cũ (nếu cần)
        });
    }
};
