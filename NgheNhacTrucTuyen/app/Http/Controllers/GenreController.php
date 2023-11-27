<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Genre;

class GenreController extends Controller {
    public function GetGenre(Request $request) {
        $output = Genre::select('id', 'name')->get();
        return response()->json($output);
    }
    // Tạo Genre
    public function addGenre(Request $request) {
        $name = $request->input('name');

        // Kiểm tra xem thể loại đã tồn tại chưa
        $existingGenre = Genre::where('name', $name)->first();
        if ($existingGenre) {
            return response()->json(['message' => 'Thể loại đã tồn tại'], 409);
        }

        // Thêm thể loại mới
        $newGenre = Genre::create(['name' => $name]);
        return response()->json(['message' => 'Thể loại đã được thêm mới thành công', 'genre' => $newGenre], 201);
    }

    // Cập nhật Genre
    public function updateGenre(Request $request, $id) {
        $name = $request->input('name');

        // Kiểm tra xem thể loại tồn tại hay không
        $genre = Genre::find($id);
        if (!$genre) {
            return response()->json(['message' => 'Thể loại không tồn tại'], 404);
        }

        // Cập nhật thông tin thể loại
        $genre->name = $name;
        $genre->save();

        return response()->json(['message' => 'Thể loại đã được cập nhật thành công', 'genre' => $genre], 200);
    }

    // Xóa Genre
    public function deleteGenre(Request $request, $id) {
        // Kiểm tra xem thể loại tồn tại hay không
        $genre = Genre::find($id);
        if (!$genre) {
            return response()->json(['message' => 'Thể loại không tồn tại'], 404);
        }

        // Xóa thể loại
        $genre->delete();

        return response()->json(['message' => 'Thể loại đã được xóa thành công'], 200);
    }
}
