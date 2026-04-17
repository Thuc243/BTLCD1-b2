@extends('layouts.app')
@section('title', 'Bài 4.4 – SV + Số môn ĐK')

@section('content')
<div class="breadcrumb">
    <a href="{{ route('students.index') }}">Dashboard</a>
    <i class="fas fa-chevron-right" style="font-size:10px"></i>
    <span>Bài 4.4 – SV kèm số môn đăng ký</span>
</div>

<div class="page-header animate-in">
    <h1><i class="fas fa-list-ol"></i> Sinh viên kèm số lượng môn đăng ký</h1>
    <p>Bài 4.4 – LEFT JOIN + groupBy để đếm số môn đăng ký</p>
</div>

<!-- Cách 1: Eloquent -->
<div class="card animate-in">
    <div class="card-header">
        <div class="card-title"><i class="fas fa-magic"></i> Cách 1: Eloquent withCount('subjects')</div>
        <span class="badge badge-primary">{{ $studentsEloquent->count() }} SV</span>
    </div>

    <div class="code-block">
        <pre><span class="comment">// Eloquent: withCount</span>
$students = Student::<span class="method">withCount</span>(<span class="string">'subjects'</span>)
    -><span class="method">with</span>(<span class="string">'classroom'</span>)
    -><span class="method">get</span>();</pre>
    </div>

    <div class="table-wrapper">
        <table>
            <thead><tr><th>ID</th><th>Họ tên</th><th>Lớp</th><th>Số môn ĐK</th><th>Hành động</th></tr></thead>
            <tbody>
                @foreach($studentsEloquent as $sv)
                <tr>
                    <td><strong>#{{ $sv->id }}</strong></td>
                    <td>
                        <div style="display:flex;align-items:center;gap:12px;">
                            <div class="avatar avatar-rose">{{ mb_substr($sv->student_name, 0, 1) }}</div>
                            <span style="font-weight:500;">{{ $sv->student_name }}</span>
                        </div>
                    </td>
                    <td><span class="badge badge-accent">{{ $sv->classroom->class_name ?? 'N/A' }}</span></td>
                    <td>
                        @if($sv->subjects_count > 0)
                            <span class="badge badge-success">{{ $sv->subjects_count }} môn</span>
                        @else
                            <span class="badge badge-danger">0 môn</span>
                        @endif
                    </td>
                    <td><a href="{{ route('students.subjects', $sv->id) }}" class="btn btn-outline btn-sm"><i class="fas fa-eye"></i> Xem</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Cách 2: Query Builder -->
<div class="card animate-in">
    <div class="card-header">
        <div class="card-title"><i class="fas fa-database"></i> Cách 2: Query Builder (LEFT JOIN + GROUP BY)</div>
        <span class="badge badge-accent">{{ $studentsQB->count() }} SV</span>
    </div>

    <div class="code-block">
        <pre><span class="comment">// Query Builder: LEFT JOIN + GROUP BY</span>
$students = DB::<span class="method">table</span>(<span class="string">'students'</span>)
    -><span class="method">leftJoin</span>(<span class="string">'student_subject'</span>, <span class="string">'students.id'</span>, <span class="string">'='</span>, <span class="string">'student_subject.student_id'</span>)
    -><span class="method">leftJoin</span>(<span class="string">'classrooms'</span>, <span class="string">'students.class_id'</span>, <span class="string">'='</span>, <span class="string">'classrooms.id'</span>)
    -><span class="method">select</span>(<span class="string">'students.id'</span>, <span class="string">'students.student_name'</span>, <span class="string">'classrooms.class_name'</span>,
        DB::<span class="method">raw</span>(<span class="string">'COUNT(student_subject.subject_id) as subjects_count'</span>))
    -><span class="method">groupBy</span>(<span class="string">'students.id'</span>, <span class="string">'students.student_name'</span>, <span class="string">'classrooms.class_name'</span>)
    -><span class="method">get</span>();</pre>
    </div>

    <div class="table-wrapper">
        <table>
            <thead><tr><th>ID</th><th>Họ tên</th><th>Lớp</th><th>Số môn ĐK</th></tr></thead>
            <tbody>
                @foreach($studentsQB as $sv)
                <tr>
                    <td><strong>#{{ $sv->id }}</strong></td>
                    <td>
                        <div style="display:flex;align-items:center;gap:12px;">
                            <div class="avatar avatar-cool">{{ mb_substr($sv->student_name, 0, 1) }}</div>
                            <span style="font-weight:500;">{{ $sv->student_name }}</span>
                        </div>
                    </td>
                    <td><span class="badge badge-accent">{{ $sv->class_name ?? 'N/A' }}</span></td>
                    <td>
                        @if($sv->subjects_count > 0)
                            <span class="badge badge-success">{{ $sv->subjects_count }} môn</span>
                        @else
                            <span class="badge badge-danger">0 môn</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
