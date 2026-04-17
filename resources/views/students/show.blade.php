@extends('layouts.app')
@section('title', 'Chi tiết SV - ' . $student->student_name)

@section('content')
<div class="breadcrumb">
    <a href="{{ route('students.index') }}">Dashboard</a>
    <i class="fas fa-chevron-right" style="font-size:10px"></i>
    <span>Chi tiết sinh viên</span>
</div>

<div class="page-header animate-in">
    <h1>{{ $student->student_name }}</h1>
    <p>Bài 6: Repository::find({{ $student->id }})</p>
</div>

<div class="stats-grid">
    <div class="stat-card animate-in">
        <div class="stat-icon"><i class="fas fa-id-card"></i></div>
        <div class="stat-number">#{{ $student->id }}</div>
        <div class="stat-label">Mã sinh viên</div>
    </div>
    <div class="stat-card animate-in">
        <div class="stat-icon"><i class="fas fa-school"></i></div>
        <div class="stat-number">{{ $student->classroom->class_name ?? 'N/A' }}</div>
        <div class="stat-label">Lớp</div>
    </div>
    <div class="stat-card animate-in">
        <div class="stat-icon"><i class="fas fa-book-open"></i></div>
        <div class="stat-number">{{ $student->subjects->count() }}</div>
        <div class="stat-label">Môn đã đăng ký</div>
    </div>
    <div class="stat-card animate-in">
        <div class="stat-icon"><i class="fas fa-circle"></i></div>
        <div class="stat-number">{{ $student->active ? 'Active' : 'Inactive' }}</div>
        <div class="stat-label">Trạng thái</div>
    </div>
</div>

<!-- Danh sách môn học đã đăng ký -->
<div class="card animate-in">
    <div class="card-header">
        <div class="card-title"><i class="fas fa-book"></i> Môn học đã đăng ký</div>
        <a href="{{ route('students.registerSubjectForm', $student->id) }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Đăng ký thêm
        </a>
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
                @forelse($student->subjects as $subject)
                <tr>
                    <td><strong>#{{ $subject->id }}</strong></td>
                    <td>
                        <div style="display:flex;align-items:center;gap:10px;">
                            <div class="avatar avatar-cool" style="width:32px;height:32px;font-size:12px;border-radius:10px;">
                                <i class="fas fa-book" style="font-size:13px;"></i>
                            </div>
                            <span style="font-weight:500;">{{ $subject->subject_name }}</span>
                        </div>
                    </td>
                    <td>
                        @if($subject->pivot->score !== null)
                            @if($subject->pivot->score >= 8)
                                <span class="badge badge-success">{{ $subject->pivot->score }}</span>
                            @elseif($subject->pivot->score >= 5)
                                <span class="badge badge-warning">{{ $subject->pivot->score }}</span>
                            @else
                                <span class="badge badge-danger">{{ $subject->pivot->score }}</span>
                            @endif
                        @else
                            <span class="badge badge-primary">Chưa có điểm</span>
                        @endif
                    </td>
                    <td>{{ $subject->pivot->registered_at ? \Carbon\Carbon::parse($subject->pivot->registered_at)->format('d/m/Y H:i') : 'N/A' }}</td>
                </tr>
                @empty
                <tr><td colspan="4" style="text-align:center;color:var(--text-muted);padding:40px;">Chưa đăng ký môn nào.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Code reference -->
<div class="card animate-in">
    <div class="card-header">
        <div class="card-title"><i class="fas fa-code"></i> Code – Repository Pattern (Bài 6)</div>
    </div>
    <div class="code-block">
        <pre><span class="comment">// StudentRepository::find($id)</span>
<span class="keyword">public function</span> <span class="method">find</span>($id)
{
    <span class="keyword">return</span> Student::<span class="method">with</span>([<span class="string">'classroom'</span>, <span class="string">'subjects'</span>])
                  -><span class="method">findOrFail</span>($id);
}</pre>
    </div>
</div>
@endsection
