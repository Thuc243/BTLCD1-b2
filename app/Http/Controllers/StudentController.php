<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Student;
use App\Models\Subject;
use App\Repositories\StudentRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    /**
     * Bài 6: Inject Repository vào Controller
     */
    protected $studentRepo;

    public function __construct(StudentRepositoryInterface $studentRepo)
    {
        $this->studentRepo = $studentRepo;
    }

    // ==================== TRANG CHÍNH ====================

    /**
     * Danh sách sinh viên (sử dụng Repository)
     * Bài 5: Áp dụng scopeActive
     */
    public function index()
    {
        // Sử dụng Repository để lấy tất cả sinh viên
        $students = $this->studentRepo->all();

        // Bài 5: Lấy sinh viên active (Local Scope)
        $activeStudents = Student::active()->with('classroom')->get();

        $classrooms = Classroom::withCount('students')->get();

        return view('students.index', compact('students', 'activeStudents', 'classrooms'));
    }

    /**
     * Chi tiết sinh viên (sử dụng Repository)
     */
    public function show($id)
    {
        $student = $this->studentRepo->find($id);

        return view('students.show', compact('student'));
    }

    // ==================== BÀI 4: QUERY BUILDER & ELOQUENT ====================

    /**
     * Bài 4.1: Lấy danh sách sinh viên thuộc lớp "CNTT1"
     */
    public function studentsByClassName()
    {
        $className = 'CNTT1';

        // Cách 1: Eloquent qua quan hệ
        $classroom = Classroom::where('class_name', $className)->first();
        $studentsEloquent = $classroom ? $classroom->students : collect();

        // Cách 2: Query Builder
        $studentsQueryBuilder = DB::table('students')
            ->join('classrooms', 'students.class_id', '=', 'classrooms.id')
            ->where('classrooms.class_name', $className)
            ->select('students.*', 'classrooms.class_name')
            ->get();

        return view('students.by_class', compact('studentsEloquent', 'studentsQueryBuilder', 'className'));
    }

    /**
     * Bài 4.2: Lấy tất cả môn học mà sinh viên có id = 5 đã đăng ký
     */
    public function subjectsByStudent($studentId = 5)
    {
        $student = Student::with('subjects')->find($studentId);
        $subjects = $student ? $student->subjects : collect();

        return view('students.subjects', compact('student', 'subjects', 'studentId'));
    }

    /**
     * Bài 4.3: Đếm số sinh viên theo từng lớp
     */
    public function countByClass()
    {
        // Eloquent: withCount
        $classrooms = Classroom::withCount('students')->get();

        // Query Builder
        $classroomsQB = DB::table('classrooms')
            ->leftJoin('students', 'classrooms.id', '=', 'students.class_id')
            ->select('classrooms.id', 'classrooms.class_name', DB::raw('COUNT(students.id) as students_count'))
            ->groupBy('classrooms.id', 'classrooms.class_name')
            ->get();

        return view('students.count_by_class', compact('classrooms', 'classroomsQB'));
    }

    /**
     * Bài 4.4: Lấy danh sách sinh viên kèm số lượng môn đăng ký (LEFT JOIN + groupBy)
     */
    public function studentsWithSubjectCount()
    {
        // Eloquent: withCount
        $studentsEloquent = Student::withCount('subjects')->with('classroom')->get();

        // Query Builder: LEFT JOIN + groupBy
        $studentsQB = DB::table('students')
            ->leftJoin('student_subject', 'students.id', '=', 'student_subject.student_id')
            ->leftJoin('classrooms', 'students.class_id', '=', 'classrooms.id')
            ->select(
                'students.id',
                'students.student_name',
                'classrooms.class_name',
                DB::raw('COUNT(student_subject.subject_id) as subjects_count')
            )
            ->groupBy('students.id', 'students.student_name', 'classrooms.class_name')
            ->get();

        return view('students.with_subject_count', compact('studentsEloquent', 'studentsQB'));
    }

    // ==================== BÀI 6: REPOSITORY (Đăng ký môn học) ====================

    /**
     * Form đăng ký môn học
     */
    public function registerSubjectForm($studentId)
    {
        $student = $this->studentRepo->find($studentId);
        $subjects = Subject::all();
        $registeredIds = $student->subjects->pluck('id')->toArray();

        return view('students.register_subject', compact('student', 'subjects', 'registeredIds'));
    }

    /**
     * Xử lý đăng ký môn học (sử dụng Repository)
     */
    public function registerSubject(Request $request, $studentId)
    {
        $request->validate([
            'subject_id' => 'required|exists:subjects,id',
        ]);

        $this->studentRepo->registerSubject($studentId, $request->subject_id);

        return redirect()->route('students.show', $studentId)
                         ->with('success', 'Đăng ký môn học thành công!');
    }

    // ==================== BÀI 6: REPOSITORY (Sinh viên theo lớp) ====================

    /**
     * Lấy sinh viên theo lớp (sử dụng Repository)
     */
    public function studentsByClass($classId)
    {
        $students = $this->studentRepo->studentsByClass($classId);
        $classroom = Classroom::findOrFail($classId);

        return view('students.by_class_id', compact('students', 'classroom'));
    }
}
