<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
class UserController extends Controller
{
    // chưa chạy được
    public function login(Request $request){
        $credentials = $request->only('username', 'password');
        $user = User::where('username', $credentials['username'])->first();
        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            // Trả về mã lỗi 401 nếu sai tài khoản hoặc mật khẩu
            return response()->json(['message' => 'Sai tài khoản hoặc mật khẩu'], 401);
        }
        // Đăng nhập thành công, trả về mã lỗi 200 và dữ liệu người dùng (nếu cần)
        return response()->json(['user' => $user, 'message' => 'Đăng nhập thành công'], 200);
    //    if (Auth::attempt($credentials)) {
    //        // Đăng nhập thành công
    //        $user = Auth::user();
    //        return response()->json(['user'=>$user, 'message'=> 'Đăng nhập thành công'],200);
    //    }else {
    //    // Đăng nhập thất bại
    //    return response()->json(['message' => 'Đăng nhập thất bại'], 401);
    //}
    }

    function register(){

    }
    function logout(){

    }
    function forgot(){

    }
    function changepwd(){

    }
}
