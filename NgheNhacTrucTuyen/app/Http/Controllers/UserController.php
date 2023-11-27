<?php

namespace App\Http\Controllers;

use App\Mail\ForgotPasswordMail;
use Carbon\Carbon;
use Illuminate\Database\Console\Migrations\ResetCommand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UserController extends Controller {
//    // chưa chạy được
//    public function login(Request $request){
//        //$credentials = $request->only('username', 'password');
//        // $user = User::where('username', $credentials['username'])->first();
//        // if (!$user || !Hash::check($credentials['password'], $user->password)) {
//            // Trả về mã lỗi 401 nếu sai tài khoản hoặc mật khẩu
//            // return response()->json(['message' => 'Sai tài khoản hoặc mật khẩu'], 401);
//        // }
//        // Đăng nhập thành công, trả về mã lỗi 200 và dữ liệu người dùng (nếu cần)
//        // return response()->json(['user' => $user, 'message' => 'Đăng nhập thành công'], 200);
//    //    if (Auth::attempt($credentials)) {
//    //        // Đăng nhập thành công
//    //        $user = Auth::user();
//    //        return response()->json(['user'=>$user, 'message'=> 'Đăng nhập thành công'],200);
//    //    }else {
//    //    // Đăng nhập thất bại
//    //    return response()->json(['message' => 'Đăng nhập thất bại'], 401);
//    //}
//
//    // Chạy được
//        $result = DB::table('users')->select('username', 'password','email','role')->get();
//        return $result;
//    }


    public function Login(Request $request) {

        $email = $request->input('email');

        $password = $request->input('password');

        // Tìm người dùng theo tên người dùng
        $user = User::where('email', $email)->first();
        if ($user) {
            // Kiểm tra mật khẩu
            if (password_verify($password, $user->password)) {
                // Đăng nhập thành công
                return response()->json(['message' => 'Login Success', 'id' => $user->id, 'role' => $user->role, 'username' => $user->username, 'avatar' => $user->avatar, 'email' => $user->email], 200);
            }
        }
        // Đăng nhập thất bại
        return response()->json(['message' => 'Wrong Username or Password'], 401);
//        return response()->json($request);
    }


    function Register(Request $request) {
        $username = $request->input('username');
        $password = $request->input('password');
        $email = $request->input('email');
        $validator = Validator::make(['email' => $email], ['email' => 'required|email',]);
        $imagePath = '\uploads\picture\default.png';
        if ($validator->fails()) {
            return response()->json(['message' => 'Invalid email'], 401);
        }
        $user = User::where('email', $email)->first();
        if ($user) {
            return response()->json(['message' => 'Email already registered'], 401);
        }
        $newUser = User::create(['username' => $username, 'password' => bcrypt($password), 'email' => $email, 'avatar' => $imagePath, 'registered_at' => Carbon::now()->format('Y-m-d H:i:s'), 'role' => 'User']);
        $id = User::where('username', $newUser->username)->first();
        return response()->json(['message' => 'Registration successful', 'id' => $id->id, 'role' => $id->role, 'username' => $id->username, 'avatar' => $id->avatar, 'email' => $id->email], 200);
    }

    function AddUser(Request $request) {
        $username = $request->input('username');
        $password = $request->input('password');
        $email = $request->input('email');
        $validator = Validator::make(['email' => $email], ['email' => 'required|email',]);
        $role = $request->input('role');
        if ($validator->fails()) {
            return response()->json(['message' => 'Invalid email'], 401);
        }
        if (User::where('email', $email)->first()) {
            return response()->json(['message', 'Email already registered'], 401);
        }
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar');
            $fileName = time() . '_' . $avatarPath->getClientOriginalName();
            $avatarPath->move(public_path('uploads/picture'), $fileName);
            $filePath = DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'picture' . DIRECTORY_SEPARATOR . $fileName;
            User::create(['username' => $username, 'password' => bcrypt($password), 'email' => $email, 'avatar' => $filePath, 'registered_at' => Carbon::now()->format('Y-m-d H:i:s'), 'role' => $role]);
            return response()->json(['message' => 'Create success']);
        }
        User::create(['username' => $username, 'password' => bcrypt($password), 'email' => $email, 'registered_at' => Carbon::now()->format('Y-m-d H:i:s'), 'role' => $role]);
        return response()->json(['message' => 'Create success']);
    }

    function UpdateUser(Request $request) {
        $id = $request->input('id');
        $dataToKeep = $request->only(['username', 'email', 'role']);
        $dataToKeep = array_filter($dataToKeep, function ($value) {
            return $value !== null && $value !== '';
        });
        if ($request->hasFile('avatar')) {
//            $oldAvatar = User::
            $avatarPath = $request->file('avatar');
            $fileName = time() . '_' . $avatarPath->getClientOriginalName();
            $avatarPath->move(public_path('uploads/picture'), $fileName);
            $filePath = DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'picture' . DIRECTORY_SEPARATOR . $fileName;
            $dataToKeep['avatar'] = $filePath;
        }
        User::where('id', $id)->update($dataToKeep);
        if ($request->hasFile('avatar')) {
            return response()->json(['message' => 'User updated successfully', 'avatar' => $filePath]);
        }
        return response()->json(['message' => 'User updated successfully']);
    }

    function Forgot(Request $request) {
        $email = $request->get('email');
        $validator = Validator::make(['email' => $email], ['email' => 'required|email',]);
        if ($validator->fails()) {
            return response()->json(['message' => 'Invalid email']);
        }
        $user = User::where('email', $email)->first();
        if (!$user) {
            return response()->json(['message' => 'Email does not match'], 401);
        }
        $newPassword = Str::random($length = 12);
        User::where('email', $email)->update(['password' => bcrypt($newPassword)]);
        Mail::to($email)->send(new ForgotPasswordMail($user, $newPassword));
        return response()->json(['message' => 'Send email'], 200);
    }

    function ChangePwd(Request $request) {
        $id = $request->get('id');
        $oldPassword = $request->get('oldPassword');
        $newPassword = $request->get('newPassword');
        $user = User::where('id', $id)->first();
        if (!password_verify($oldPassword, $user->password)) {
            return response()->json(['message' => 'Old password is not correct'], 401);
        }
        User::where('id', $id)->update(['password' => bcrypt($newPassword)]);
        return response()->json(['message' => 'Change password successfully'], 200);
    }

    public function GetUserById(Request $request, $id) {
        // Tìm người dùng theo ID
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Trả về thông tin chi tiết của người dùng
        return response()->json(['user' => $user], 200);
    }

    public function GetUser(Request $request) {
        if ($request->has('start')) {
            $records = User::count();
            $start = $request->input('start');
            $output = User::select('id', 'avatar', 'username', 'email', 'registered_at', 'role')->orderBy('id')->skip($start)->take(10)->get();
            return response()->json(['records' => $records, 'users' => $output]);
        }
        if ($request->has('id')) {
            $id = $request->input('id');
            return response()->json(User::where('id', $id)->select('avatar', 'username', 'email', 'role')->first());
        }
        return response()->json(User::select('id', 'avatar', 'username', 'email', 'registered_at', 'role')->get());
    }

    public function DeleteUser(Request $request) {
        $userId = $request->input('id');
        User::where('id', $userId)->delete();
        if (User::where('id', $userId)->exists()) {
            return response()->json(['message' => 'Xóa thất bại'], 500);
        } else {
            return response()->json(['message' => 'Xóa thành công']);
        }
    }
}
