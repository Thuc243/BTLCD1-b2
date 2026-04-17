<?php

namespace App\Repositories;

use App\Models\Student;
use Carbon\Carbon;

/**
 * Bài 6: Repository Pattern - Implementation
 */
class StudentRepository implements StudentRepositoryInterface
{
    /**
     * Lấy tất cả sinh viên (kèm quan hệ classroom)
     */
    public function all()
    {
        return Student::with('classroom')->get();
    }

    /**
     * Tìm sinh viên theo ID (kèm quan hệ classroom + subjects)
     */
    public function find($id)
    {
        return Student::with(['classroom', 'subjects'])->findOrFail($id);
    }

    /**
     * Lấy danh sách sinh viên theo lớp
     */
    public function studentsByClass($classId)
    {
        return Student::where('class_id', $classId)->with('classroom')->get();
    }

    /**
     * Đăng ký môn học cho sinh viên
     */
    public function registerSubject($studentId, $subjectId)
    {
        $student = Student::findOrFail($studentId);

        // Đăng ký môn học (không trùng lặp) với thời gian đăng ký
        $student->subjects()->syncWithoutDetaching([
            $subjectId => ['registered_at' => Carbon::now()]
        ]);

        return $student->load('subjects');
    }
}
