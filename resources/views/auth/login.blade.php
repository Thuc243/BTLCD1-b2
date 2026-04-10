@extends('layouts.app')

@section('content')

<h2>Đăng nhập</h2>

<form method="POST" action="/login">
    @csrf

    <input type="email" name="email" placeholder="Email"><br><br>

    <input type="password" name="password" placeholder="Mật khẩu"><br><br>

    <button type="submit">Đăng nhập</button>
</form>

<p>Chưa có tài khoản? <a href="/register">Đăng ký</a></p>

@endsection