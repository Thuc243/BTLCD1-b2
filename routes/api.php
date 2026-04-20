<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\StudentController;

// Lấy thông tin user hiện tại (nếu dùng xác thực, mặc định tắt trong bài lab)
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// RESTful API cho bảng students
Route::apiResource('students', StudentController::class);
