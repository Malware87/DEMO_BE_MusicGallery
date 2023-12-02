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

    public function GetSingerById(Request $request, $id) {
        // Tìm người dùng theo ID
        $singer = Singer::find($id);

        if (!$singer) {
            return response()->json(['message' => 'Singer not found'], 404);
        }
        // Trả về thông tin chi tiết của người dùng
        return response()->json(['Singer' => $singer], 200);
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

}

