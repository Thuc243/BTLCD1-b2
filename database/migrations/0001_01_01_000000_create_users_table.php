<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations (Tạo bảng)
     */
    public function up(): void
    {
        // ================= USERS =================
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // ID tự tăng
            $table->string('name'); // Tên người dùng
            $table->string('email')->unique(); // Email (không trùng)
            $table->timestamp('email_verified_at')->nullable(); // Xác minh email
            $table->string('password'); // Mật khẩu
            $table->rememberToken(); // Ghi nhớ đăng nhập
            $table->timestamps(); // created_at, updated_at
        });

        // ================= RESET PASSWORD =================
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary(); // Email là khóa chính
            $table->string('token'); // Token reset mật khẩu
            $table->timestamp('created_at')->nullable(); // Thời gian tạo
        });

        // ================= SESSIONS =================
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary(); // Session ID
            $table->foreignId('user_id')->nullable()->index(); // ID user
            $table->string('ip_address', 45)->nullable(); // IP
            $table->text('user_agent')->nullable(); // Trình duyệt
            $table->longText('payload'); // Dữ liệu session
            $table->integer('last_activity')->index(); // Hoạt động cuối
        });
    }

    /**
     * Reverse the migrations (Xóa bảng)
     */
    public function down(): void
    {
        // Xóa theo thứ tự ngược lại để tránh lỗi khóa ngoại
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('users');
    }
};