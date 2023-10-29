<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class UserController extends Controller
{
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


    public function login(Request $request) {
        $username = $request->input('username');
        $password = $request->input('password');

        // Tìm người dùng theo tên người dùng
        $user = User::where('username', $username)->first();
        if ($user) {
            // Kiểm tra mật khẩu
            if ($password == $user->password) {
                // Đăng nhập thành công
                return response()->json(['user' => $user, 'message' => 'Login Success'], 200);
            }
        }
        // Đăng nhập thất bại
        return response()->json(['message' => 'Wrong Username or Password'], 401);
//        return response()->json($request);
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
