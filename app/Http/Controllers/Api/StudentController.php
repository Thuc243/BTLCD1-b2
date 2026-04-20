<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     * GET /api/students
     */
    public function index(): JsonResponse
    {
        $students = Student::with('classroom')->get();
        return response()->json([
            'success' => true,
            'message' => 'Lấy danh sách sinh viên thành công',
            'data' => $students
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     * POST /api/students
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'student_name' => 'required|string|max:255',
            'class_id' => 'required|exists:classrooms,id',
            'active' => 'sometimes|boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi xác thực dữ liệu',
                'errors' => $validator->errors()
            ], 422);
        }

        $student = Student::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Thêm sinh viên thành công',
            'data' => $student
        ], 201);
    }

    /**
     * Display the specified resource.
     * GET /api/students/{id}
     */
    public function show(string $id): JsonResponse
    {
        $student = Student::with(['classroom', 'subjects'])->find($id);

        if (!$student) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy sinh viên',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Lấy thông tin sinh viên thành công',
            'data' => $student
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     * PUT/PATCH /api/students/{id}
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $student = Student::find($id);

        if (!$student) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy sinh viên',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'student_name' => 'sometimes|string|max:255',
            'class_id' => 'sometimes|exists:classrooms,id',
            'active' => 'sometimes|boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi xác thực dữ liệu',
                'errors' => $validator->errors()
            ], 422);
        }

        $student->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Cập nhật thông tin sinh viên thành công',
            'data' => $student
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     * DELETE /api/students/{id}
     */
    public function destroy(string $id): JsonResponse
    {
        $student = Student::find($id);

        if (!$student) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy sinh viên',
            ], 404);
        }

        $student->delete();

        return response()->json([
            'success' => true,
            'message' => 'Xoá sinh viên thành công',
        ], 200);
    }
}
