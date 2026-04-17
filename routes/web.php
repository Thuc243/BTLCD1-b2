<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentController;

// Trang chủ (sau khi login)
Route::get('/home', function () {
    return view('home');
})->middleware('auth');

// ================= AUTH =================

// Register
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Login
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');

// Redirect mặc định
Route::get('/', function () {
    return redirect('/students');
});

// ================= STUDENT MANAGEMENT =================

// Bài 4.1: Sinh viên thuộc lớp CNTT1
Route::get('/students/by-class-name', [StudentController::class, 'studentsByClassName'])->name('students.byClassName');

// Bài 4.2: Môn học của sinh viên
Route::get('/students/{studentId}/subjects', [StudentController::class, 'subjectsByStudent'])->name('students.subjects');

// Bài 4.3: Đếm sinh viên theo lớp
Route::get('/students/count-by-class', [StudentController::class, 'countByClass'])->name('students.countByClass');

// Bài 4.4: Sinh viên kèm số môn đăng ký
Route::get('/students/with-subject-count', [StudentController::class, 'studentsWithSubjectCount'])->name('students.withSubjectCount');

// Bài 6: Đăng ký môn học
Route::get('/students/{studentId}/register-subject', [StudentController::class, 'registerSubjectForm'])->name('students.registerSubjectForm');
Route::post('/students/{studentId}/register-subject', [StudentController::class, 'registerSubject'])->name('students.registerSubject');

// Bài 6: Sinh viên theo lớp (by ID)
Route::get('/students/class/{classId}', [StudentController::class, 'studentsByClass'])->name('students.byClass');

// Danh sách & chi tiết
Route::get('/students', [StudentController::class, 'index'])->name('students.index');
Route::get('/students/{id}', [StudentController::class, 'show'])->name('students.show');