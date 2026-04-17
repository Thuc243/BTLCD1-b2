@extends('layouts.app')
@section('title', 'Bài 4.2 – Môn học của SV #' . $studentId)

@section('content')
<div class="breadcrumb">
    <a href="{{ route('students.index') }}">Dashboard</a>
    <i class="fas fa-chevron-right" style="font-size:10px"></i>
    <span>Bài 4.2 – Môn học của sinh viên</span>
</div>

<div class="page-header animate-in">
    <h1><i class="fas fa-book"></i> Môn học SV có id = {{ $studentId }}</h1>
    <p>Bài 4.2 – Lấy tất cả môn học mà sinh viên có id = {{ $studentId }} đã đăng ký</p>
</div>

<div class="card animate-in">
    <div class="card-header">
        <div class="card-title">
            <i class="fas fa-user"></i>
            @if($student)
                {{ $student->student_name }} – {{ $student->classroom->class_name ?? '' }}
            @else
                Không tìm thấy sinh viên
            @endif
        </div>
        <span class="badge badge-primary">{{ $subjects->count() }} môn</span>
    </div>

    <div class="code-block">
        <pre><span class="comment">// Eloquent: Many-to-Many</span>
$student = Student::<span class="method">with</span>(<span class="string">'subjects'</span>)-><span class="method">find</span>({{ $studentId }});
$subjects = $student-><span class="method">subjects</span>;</pre>
    </div>

    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>ID Môn</th>
                    <th>Tên môn học</th>
                    <th>Điểm</th>
                    <th>Ngày đăng ký</th>
                </tr>
            </thead>
            <tbody>
                @forelse($subjects as $sub)
                <tr>
                    <td><strong>#{{ $sub->id }}</strong></td>
                    <td>
                        <div style="display:flex;align-items:center;gap:10px;">
                            <div class="avatar avatar-cool" style="width:32px;height:32px;font-size:12px;border-radius:10px;">
                                <i class="fas fa-book" style="font-size:13px;"></i>
                            </div>
                            <span style="font-weight:500;">{{ $sub->subject_name }}</span>
                        </div>
                    </td>
                    <td>
                        @if($sub->pivot->score !== null)
                            @if($sub->pivot->score >= 8)
                                <span class="badge badge-success">{{ $sub->pivot->score }}</span>
                            @elseif($sub->pivot->score >= 5)
                                <span class="badge badge-warning">{{ $sub->pivot->score }}</span>
                            @else
                                <span class="badge badge-danger">{{ $sub->pivot->score }}</span>
                            @endif
                        @else
                            <span class="badge badge-primary">Chưa có điểm</span>
                        @endif
                    </td>
                    <td>{{ $sub->pivot->registered_at ? \Carbon\Carbon::parse($sub->pivot->registered_at)->format('d/m/Y H:i') : 'N/A' }}</td>
                </tr>
                @empty
                <tr><td colspan="4" style="text-align:center;color:var(--text-muted);padding:40px;">Sinh viên chưa đăng ký môn nào.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
