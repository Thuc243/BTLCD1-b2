@extends('layouts.app')
@section('title', 'Sinh viên lớp ' . $classroom->class_name)

@section('content')
<div class="breadcrumb">
    <a href="{{ route('students.index') }}">Dashboard</a>
    <i class="fas fa-chevron-right" style="font-size:10px"></i>
    <span>Sinh viên lớp {{ $classroom->class_name }}</span>
</div>

<div class="page-header animate-in">
    <h1><i class="fas fa-users"></i> Sinh viên lớp {{ $classroom->class_name }}</h1>
    <p>Bài 6: Repository::studentsByClass({{ $classroom->id }})</p>
</div>

<div class="card animate-in">
    <div class="card-header">
        <div class="card-title"><i class="fas fa-users"></i> Danh sách sinh viên</div>
        <span class="badge badge-primary">{{ $students->count() }} SV</span>
    </div>

    <div class="code-block">
        <pre><span class="comment">// Bài 6: Repository - studentsByClass()</span>
<span class="keyword">public function</span> <span class="method">studentsByClass</span>($classId)
{
    <span class="keyword">return</span> Student::<span class="method">where</span>(<span class="string">'class_id'</span>, $classId)
                  -><span class="method">with</span>(<span class="string">'classroom'</span>)
                  -><span class="method">get</span>();
}</pre>
    </div>

    <div class="table-wrapper">
        <table>
            <thead><tr><th>ID</th><th>Họ tên</th><th>Lớp</th><th>Trạng thái</th><th>Hành động</th></tr></thead>
            <tbody>
                @forelse($students as $sv)
                <tr>
                    <td><strong>#{{ $sv->id }}</strong></td>
                    <td>
                        <div style="display:flex;align-items:center;gap:12px;">
                            <div class="avatar avatar-rose">{{ mb_substr($sv->student_name, 0, 1) }}</div>
                            <span style="font-weight:500;">{{ $sv->student_name }}</span>
                        </div>
                    </td>
                    <td><span class="badge badge-accent">{{ $sv->classroom->class_name }}</span></td>
                    <td>
                        @if($sv->active)
                            <span class="badge badge-success"><i class="fas fa-circle" style="font-size:7px"></i> Active</span>
                        @else
                            <span class="badge badge-danger"><i class="fas fa-circle" style="font-size:7px"></i> Inactive</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('students.show', $sv->id) }}" class="btn btn-outline btn-sm"><i class="fas fa-eye"></i> Chi tiết</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" style="text-align:center;color:var(--text-muted);padding:40px;">Lớp chưa có sinh viên.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
