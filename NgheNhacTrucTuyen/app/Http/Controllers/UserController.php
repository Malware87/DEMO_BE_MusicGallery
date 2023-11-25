<?php

namespace App\Http\Controllers;

use App\Mail\ForgotPasswordMail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

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
                return response()->json(['message' => 'Login Success', 'id' => $user->id], 200);
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
            return response()->json(['message' => 'Invalid email']);
        }
        $user = User::where('username', $username)->orWhere('email', $email)->first();
        if ($user) {
            return response()->json(['message' => 'Username or Email already registered'], 401);
        }
        $newUser = User::create(['username' => $username, 'password' => bcrypt($password), 'email' => $email, 'avatar' => $imagePath, 'registered_at' => Carbon::now()->format('Y-m-d H:i:s'), 'role' => 'User']);
        $id = User::where('username', $newUser->username)->select('id')->first();
        return response()->json(['message' => 'Registration successful', 'id' => $id->id], 200);
    }

    function Forgot(Request $request) {
        $email = $request->get('email');
        $validator = Validator::make(['email' => $email], ['email' => 'required|email',]);
        if ($validator->fails()) {
            return response()->json(['message' => 'Invalid email']);
        }
        Mail::to($email)->send(new ForgotPasswordMail());
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
