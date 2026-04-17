@extends('layouts.app')
@section('title', 'Bài 4.1 – SV thuộc lớp ' . $className)

@section('content')
<div class="breadcrumb">
    <a href="{{ route('students.index') }}">Dashboard</a>
    <i class="fas fa-chevron-right" style="font-size:10px"></i>
    <span>Bài 4.1 – Sinh viên theo lớp</span>
</div>

<div class="page-header animate-in">
    <h1><i class="fas fa-search"></i> Sinh viên thuộc lớp "{{ $className }}"</h1>
    <p>Bài 4.1 – Lấy danh sách sinh viên bằng Eloquent & Query Builder</p>
</div>

<!-- Cách 1: Eloquent -->
<div class="card animate-in">
    <div class="card-header">
        <div class="card-title"><i class="fas fa-magic"></i> Cách 1: Eloquent (qua quan hệ)</div>
        <span class="badge badge-primary">{{ $studentsEloquent->count() }} kết quả</span>
    </div>

    <div class="code-block">
        <pre><span class="comment">// Eloquent: qua quan hệ hasMany</span>
$classroom = Classroom::<span class="method">where</span>(<span class="string">'class_name'</span>, <span class="string">'CNTT1'</span>)-><span class="method">first</span>();
$students = $classroom-><span class="method">students</span>;</pre>
    </div>

    <div class="table-wrapper">
        <table>
            <thead><tr><th>ID</th><th>Họ tên</th><th>Trạng thái</th></tr></thead>
            <tbody>
                @forelse($studentsEloquent as $sv)
                <tr>
                    <td><strong>#{{ $sv->id }}</strong></td>
                    <td>
                        <div style="display:flex;align-items:center;gap:12px;">
                            <div class="avatar avatar-rose">{{ mb_substr($sv->student_name, 0, 1) }}</div>
                            <span style="font-weight:500;">{{ $sv->student_name }}</span>
                        </div>
                    </td>
                    <td>
                        @if($sv->active)
                            <span class="badge badge-success"><i class="fas fa-circle" style="font-size:7px"></i> Active</span>
                        @else
                            <span class="badge badge-danger"><i class="fas fa-circle" style="font-size:7px"></i> Inactive</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="3" style="text-align:center;color:var(--text-muted);padding:40px;">Không tìm thấy.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Cách 2: Query Builder -->
<div class="card animate-in">
    <div class="card-header">
        <div class="card-title"><i class="fas fa-database"></i> Cách 2: Query Builder (JOIN)</div>
        <span class="badge badge-accent">{{ $studentsQueryBuilder->count() }} kết quả</span>
    </div>

    <div class="code-block">
        <pre><span class="comment">// Query Builder: JOIN</span>
$students = DB::<span class="method">table</span>(<span class="string">'students'</span>)
    -><span class="method">join</span>(<span class="string">'classrooms'</span>, <span class="string">'students.class_id'</span>, <span class="string">'='</span>, <span class="string">'classrooms.id'</span>)
    -><span class="method">where</span>(<span class="string">'classrooms.class_name'</span>, <span class="string">'CNTT1'</span>)
    -><span class="method">select</span>(<span class="string">'students.*'</span>, <span class="string">'classrooms.class_name'</span>)
    -><span class="method">get</span>();</pre>
    </div>

    <div class="table-wrapper">
        <table>
            <thead><tr><th>ID</th><th>Họ tên</th><th>Lớp</th></tr></thead>
            <tbody>
                @forelse($studentsQueryBuilder as $sv)
                <tr>
                    <td><strong>#{{ $sv->id }}</strong></td>
                    <td>
                        <div style="display:flex;align-items:center;gap:12px;">
                            <div class="avatar avatar-cool">{{ mb_substr($sv->student_name, 0, 1) }}</div>
                            <span style="font-weight:500;">{{ $sv->student_name }}</span>
                        </div>
                    </td>
                    <td><span class="badge badge-accent">{{ $sv->class_name }}</span></td>
                </tr>
                @empty
                <tr><td colspan="3" style="text-align:center;color:var(--text-muted);padding:40px;">Không tìm thấy.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
