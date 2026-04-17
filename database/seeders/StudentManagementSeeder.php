<?php

namespace Database\Seeders;

use App\Models\Classroom;
use App\Models\Student;
use App\Models\Subject;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class StudentManagementSeeder extends Seeder
{
    public function run(): void
    {
        // Tạo Lớp học
        $cntt1 = Classroom::create(['class_name' => 'CNTT1']);
        $cntt2 = Classroom::create(['class_name' => 'CNTT2']);
        $cntt3 = Classroom::create(['class_name' => 'CNTT3']);

        // Tạo Môn học
        $php = Subject::create(['subject_name' => 'Lập trình PHP']);
        $java = Subject::create(['subject_name' => 'Lập trình Java']);
        $python = Subject::create(['subject_name' => 'Lập trình Python']);
        $db = Subject::create(['subject_name' => 'Cơ sở dữ liệu']);
        $web = Subject::create(['subject_name' => 'Phát triển Web']);

        // Tạo Sinh viên - Lớp CNTT1
        $sv1 = Student::create(['student_name' => 'Nguyễn Văn An', 'class_id' => $cntt1->id, 'active' => true]);
        $sv2 = Student::create(['student_name' => 'Trần Thị Bình', 'class_id' => $cntt1->id, 'active' => true]);
        $sv3 = Student::create(['student_name' => 'Lê Hoàng Cường', 'class_id' => $cntt1->id, 'active' => false]);

        // Tạo Sinh viên - Lớp CNTT2
        $sv4 = Student::create(['student_name' => 'Phạm Minh Đức', 'class_id' => $cntt2->id, 'active' => true]);
        $sv5 = Student::create(['student_name' => 'Hoàng Thị Em', 'class_id' => $cntt2->id, 'active' => true]);
        $sv6 = Student::create(['student_name' => 'Võ Văn Phú', 'class_id' => $cntt2->id, 'active' => true]);

        // Tạo Sinh viên - Lớp CNTT3
        $sv7 = Student::create(['student_name' => 'Đặng Thị Giang', 'class_id' => $cntt3->id, 'active' => true]);
        $sv8 = Student::create(['student_name' => 'Bùi Văn Hải', 'class_id' => $cntt3->id, 'active' => false]);

        // Đăng ký môn học (pivot) với điểm
        $sv1->subjects()->attach([
            $php->id   => ['score' => 8.5, 'registered_at' => Carbon::now()->subDays(30)],
            $java->id  => ['score' => 7.0, 'registered_at' => Carbon::now()->subDays(25)],
            $db->id    => ['score' => 9.0, 'registered_at' => Carbon::now()->subDays(20)],
        ]);

        $sv2->subjects()->attach([
            $python->id => ['score' => 8.0, 'registered_at' => Carbon::now()->subDays(28)],
            $web->id    => ['score' => 9.5, 'registered_at' => Carbon::now()->subDays(22)],
        ]);

        $sv3->subjects()->attach([
            $php->id   => ['score' => 6.5, 'registered_at' => Carbon::now()->subDays(30)],
            $db->id    => ['score' => null, 'registered_at' => Carbon::now()->subDays(5)],
        ]);

        $sv4->subjects()->attach([
            $java->id   => ['score' => 7.5, 'registered_at' => Carbon::now()->subDays(15)],
            $python->id => ['score' => 8.5, 'registered_at' => Carbon::now()->subDays(10)],
            $web->id    => ['score' => 9.0, 'registered_at' => Carbon::now()->subDays(8)],
        ]);

        $sv5->subjects()->attach([
            $php->id => ['score' => 9.0, 'registered_at' => Carbon::now()->subDays(20)],
            $db->id  => ['score' => 8.0, 'registered_at' => Carbon::now()->subDays(18)],
        ]);

        $sv6->subjects()->attach([
            $web->id => ['score' => 7.0, 'registered_at' => Carbon::now()->subDays(12)],
        ]);

        $sv7->subjects()->attach([
            $php->id    => ['score' => 8.0, 'registered_at' => Carbon::now()->subDays(25)],
            $java->id   => ['score' => 7.5, 'registered_at' => Carbon::now()->subDays(20)],
            $python->id => ['score' => 9.0, 'registered_at' => Carbon::now()->subDays(15)],
            $db->id     => ['score' => 8.5, 'registered_at' => Carbon::now()->subDays(10)],
        ]);

        $sv8->subjects()->attach([
            $java->id => ['score' => null, 'registered_at' => Carbon::now()->subDays(3)],
        ]);
    }
}
