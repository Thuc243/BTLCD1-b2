<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // ================= REGISTER =================

    // Hiển thị form đăng ký
    public function showRegister()
    {
        return view('auth.register');
    }

    // Xử lý đăng ký
    public function register(Request $request)
    {
        // Validate dữ liệu
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed'
        ]);

        // Tạo user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        // Tự động đăng nhập sau khi đăng ký
        Auth::login($user);

        return redirect('/home')->with('success', 'Đăng ký thành công!');
    }

    // ================= LOGIN =================

    // Hiển thị form đăng nhập
    public function showLogin()
    {
        return view('auth.login');
    }

    // Xử lý đăng nhập
    public function login(Request $request)
    {
        // Validate
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Kiểm tra đăng nhập
        if (Auth::attempt($request->only('email', 'password'))) {
            $request->session()->regenerate(); // chống session fixation
            return redirect('/home')->with('success', 'Đăng nhập thành công!');
        }

        return back()->with('error', 'Sai email hoặc mật khẩu!');
    }

    // ================= LOGOUT =================

    public function logout(Request $request)
    {
        Auth::logout();

        // Hủy session
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Đăng xuất thành công!');
    }
}