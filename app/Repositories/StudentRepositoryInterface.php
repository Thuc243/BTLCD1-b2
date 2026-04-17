<?php

namespace App\Repositories;

/**
 * Bài 6: Repository Pattern - Interface
 */
interface StudentRepositoryInterface
{
    /**
     * Lấy tất cả sinh viên
     */
    public function all();

    /**
     * Tìm sinh viên theo ID
     */
    public function find($id);

    /**
     * Lấy danh sách sinh viên theo lớp
     */
    public function studentsByClass($classId);

    /**
     * Đăng ký môn học cho sinh viên
     */
    public function registerSubject($studentId, $subjectId);
}
