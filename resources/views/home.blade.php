@extends('layouts.app')

@section('content')

<h2>Xin chào {{ auth()->user()->name }}</h2>

<form method="POST" action="/logout">
    @csrf
    <button type="submit">Đăng xuất</button>
</form>

@endsection