@extends('layouts.app')

@section('content')

<h2>Đăng ký</h2>

<form method="POST" action="/register">
    @csrf

    <input type="text" name="name" placeholder="Tên"><br><br>

    <input type="email" name="email" placeholder="Email"><br><br>

    <input type="password" name="password" placeholder="Mật khẩu"><br><br>

    <input type="password" name="password_confirmation" placeholder="Nhập lại mật khẩu"><br><br>

    <button type="submit">Đăng ký</button>
</form>

<p>Đã có tài khoản? <a href="/login">Đăng nhập</a></p>

@endsection