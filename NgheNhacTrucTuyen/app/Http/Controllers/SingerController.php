<?php

namespace App\Http\Controllers;

use App\Mail\ForgotPasswordMail;
use App\Models\Genre;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Migrations\ResetCommand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Singer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class SingerController extends Controller {
    function AddSinger(Request $request) {
        $name = $request->input('name');
        $singerDescription = $request->input('singerDescription');
        if ($request->hasFile('urlAvatar')) {
            $avatarPath = $request->file('urlAvatar');
            $fileName = time() . '_' . $avatarPath->getClientOriginalName();
            $avatarPath->move(public_path('uploads/picture'), $fileName);
            $filePath = DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'picture' . DIRECTORY_SEPARATOR . $fileName;
            Singer::create(['name' => $name, 'singerDescription' => $singerDescription, 'urlAvatar' => $filePath]);
            return response()->json(['message' => 'Create success']);
        }
        Singer::create(['name' => $name, 'singerDescription' => $singerDescription]);
        return response()->json(['message' => 'Create success']);
    }

    public function GetSinger(Request $request) {
        if ($request->has('start')) {
            $records = Singer::count();
            $start = $request->input('start');
            $output = Singer::select('id', 'urlAvatar', 'name', 'singerDescription')->orderBy('id')->skip($start)->take(10)->get();
            return response()->json(['records' => $records, 'singer' => $output]);
        }
        if ($request->has('id')) {
            $id = $request->input('id');
            return response()->json(Singer::where('id', $id)->select('urlAvatar', 'name', 'singerDescription')->first());
        }
        return response()->json(Singer::select('id', 'urlAvatar', 'name', 'singerDescription')->get());
    }


    function UpdateSinger(Request $request) {
        $id = $request->input('id');
        $dataToKeep = $request->only(['name', 'singerDescription']);
        $dataToKeep = array_filter($dataToKeep, function ($value) {
            return $value !== null && $value !== '';
        });
        if ($request->hasFile('urlAvatar')) {
            $avatarPath = $request->file('urlAvatar');
            $fileName = time() . '_' . $avatarPath->getClientOriginalName();
            $avatarPath->move(public_path('uploads/picture'), $fileName);
            $filePath = DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'picture' . DIRECTORY_SEPARATOR . $fileName;
            $dataToKeep['urlAvatar'] = $filePath;
        }
        Singer::where('id', $id)->update($dataToKeep);
        if ($request->hasFile('urlAvatar')) {
            return response()->json(['message' => 'Singer updated successfully', 'urlAvatar' => $filePath]);
        }
        return response()->json(['message' => 'Singer updated successfully']);
    }

    public function DeleteSinger(Request $request) {
        $singerID = $request->input('id');

        // Tìm người ca sĩ theo ID
        $singer = Singer::find($singerID);

        // Kiểm tra xem người ca sĩ có tồn tại hay không
        if (!$singer) {
            return response()->json(['message' => 'Singer không tồn tại'], 404);
        }
        // Xóa người ca sĩ
        $singer->delete();
        // Kiểm tra xem người ca sĩ đã được xóa thành công hay không
        if (Singer::where('id', $singerID)->exists()) {
            return response()->json(['message' => 'Xóa thất bại'], 500);
        } else {
            return response()->json(['message' => 'Xóa thành công']);
        }
    }
    public function getSingerBySong(Request $request) {
        $songID = $request->input('songID');
        // Tìm bài hát theo ID
        $song = Song::find($songID);

        // Kiểm tra xem bài hát có tồn tại hay không
        if (!$song) {
            return response()->json(['message' => 'Bài hát không tồn tại'], 404);
        }
        // Lấy thông tin ca sĩ của bài hát
        $singer = $song->singer;
        // Kiểm tra xem ca sĩ đã được lấy hay không
        if (!$singer) {
            return response()->json(['message' => 'Không tìm thấy ca sĩ của bài hát'], 404);
        }
        // Trả về thông tin ca sĩ của bài hát
        return response()->json($singer);
    }

    public function getTotalListenCount(Request $request)
    {
        // Lấy id của ca sĩ từ request
        $singerId = $request->input('id');
        // Kiểm tra xem id có tồn tại không
        if (!$singerId) {
            return response()->json(['error' => 'Singer ID is required'], 400);
        }
        // Tìm ca sĩ theo id
        $singer = Singer::find($singerId);
        // Kiểm tra xem ca sĩ có tồn tại không
        if (!$singer) {
            return response()->json(['error' => 'Singer not found'], 404);
        }
        // Lấy tổng listen_count của ca sĩ
        $totalListenCount = $singer->getTotalListenCount();
        // Trả về kết quả dưới dạng JSON
        return response()->json(['total_listen_count' => $totalListenCount]);
    }
}

