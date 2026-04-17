@extends('layouts.app')
@section('title', 'Dashboard - Quản Lý Sinh Viên')

@section('content')
<div class="page-header animate-in">
    <h1><i class="fas fa-tachometer-alt"></i> Dashboard Quản Lý Sinh Viên</h1>
    <p>Tổng quan hệ thống – Bài 4, 5, 6</p>
</div>

<!-- Stats Cards -->
<div class="stats-grid">
    <div class="stat-card animate-in">
        <div class="stat-icon"><i class="fas fa-users"></i></div>
        <div class="stat-number">{{ $students->count() }}</div>
        <div class="stat-label">Tổng sinh viên</div>
    </div>
    <div class="stat-card animate-in">
        <div class="stat-icon"><i class="fas fa-school"></i></div>
        <div class="stat-number">{{ $classrooms->count() }}</div>
        <div class="stat-label">Lớp học</div>
    </div>
    <div class="stat-card animate-in">
        <div class="stat-icon"><i class="fas fa-user-check"></i></div>
        <div class="stat-number">{{ $activeStudents->count() }}</div>
        <div class="stat-label">SV Active (Scope)</div>
    </div>
    <div class="stat-card animate-in">
        <div class="stat-icon"><i class="fas fa-user-times"></i></div>
        <div class="stat-number">{{ $students->count() - $activeStudents->count() }}</div>
        <div class="stat-label">SV Inactive</div>
    </div>
</div>

<!-- Tabs: Tất cả / Active -->
<div class="card animate-in">
    <div class="tabs">
        <button class="tab {{ request('tab') !== 'active' ? 'active' : '' }}" onclick="showTab('all')">
            <i class="fas fa-users"></i>&nbsp; Tất cả SV ({{ $students->count() }})
        </button>
        <button class="tab {{ request('tab') === 'active' ? 'active' : '' }}" onclick="showTab('active')">
            <i class="fas fa-user-check"></i>&nbsp; Active Scope ({{ $activeStudents->count() }})
        </button>
    </div>

    <!-- Tab: Tất cả -->
    <div id="tab-all" class="tab-content {{ request('tab') !== 'active' ? 'active' : '' }}">
        <div class="card-header">
            <div class="card-title"><i class="fas fa-list"></i> Danh sách tất cả sinh viên</div>
            <span class="badge badge-primary">Repository::all()</span>
        </div>
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Họ tên</th>
                        <th>Lớp</th>
                        <th>Trạng thái</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($students as $sv)
                    <tr>
                        <td><strong>#{{ $sv->id }}</strong></td>
                        <td>
                            <div style="display:flex;align-items:center;gap:12px;">
                                <div class="avatar avatar-rose">
                                    {{ mb_substr($sv->student_name, 0, 1) }}
                                </div>
                                <span style="font-weight:500;">{{ $sv->student_name }}</span>
                            </div>
                        </td>
                        <td><span class="badge badge-accent">{{ $sv->classroom->class_name ?? 'N/A' }}</span></td>
                        <td>
                            @if($sv->active)
                                <span class="badge badge-success"><i class="fas fa-circle" style="font-size:7px"></i> Active</span>
                            @else
                                <span class="badge badge-danger"><i class="fas fa-circle" style="font-size:7px"></i> Inactive</span>
                            @endif
                        </td>
                        <td>
                            <div style="display:flex;gap:8px;">
                                <a href="{{ route('students.show', $sv->id) }}" class="btn btn-outline btn-sm"><i class="fas fa-eye"></i> Chi tiết</a>
                                <a href="{{ route('students.registerSubjectForm', $sv->id) }}" class="btn btn-sm btn-success"><i class="fas fa-plus"></i> ĐK Môn</a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" style="text-align:center;color:var(--text-muted);padding:40px;">Chưa có sinh viên nào.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Tab: Active Scope -->
    <div id="tab-active" class="tab-content {{ request('tab') === 'active' ? 'active' : '' }}">
        <div class="card-header">
            <div class="card-title"><i class="fas fa-user-check"></i> Bài 5 – Local Scope: Active</div>
            <span class="badge badge-success">Student::active()->get()</span>
        </div>

        <div class="code-block">
            <pre><span class="comment">// Bài 5: Local Scope trong Model</span>
<span class="keyword">public function</span> <span class="method">scopeActive</span>(Builder $query): Builder
{
    <span class="keyword">return</span> $query-><span class="method">where</span>(<span class="string">'active'</span>, <span class="keyword">true</span>);
}

<span class="comment">// Sử dụng trong Controller</span>
$activeStudents = Student::<span class="method">active</span>()-><span class="method">with</span>(<span class="string">'classroom'</span>)-><span class="method">get</span>();</pre>
        </div>

        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Họ tên</th>
                        <th>Lớp</th>
                        <th>Trạng thái</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($activeStudents as $sv)
                    <tr>
                        <td><strong>#{{ $sv->id }}</strong></td>
                        <td>
                            <div style="display:flex;align-items:center;gap:12px;">
                                <div class="avatar avatar-nature">
                                    {{ mb_substr($sv->student_name, 0, 1) }}
                                </div>
                                <span style="font-weight:500;">{{ $sv->student_name }}</span>
                            </div>
                        </td>
                        <td><span class="badge badge-accent">{{ $sv->classroom->class_name ?? 'N/A' }}</span></td>
                        <td><span class="badge badge-success"><i class="fas fa-check-circle"></i> Active</span></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Lớp học + số SV -->
<div class="card animate-in">
    <div class="card-header">
        <div class="card-title"><i class="fas fa-school"></i> Lớp học & Số sinh viên</div>
    </div>
    <div class="stats-grid">
        @foreach($classrooms as $cls)
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-chalkboard-teacher"></i></div>
            <div class="stat-number">{{ $cls->students_count }}</div>
            <div class="stat-label">{{ $cls->class_name }}</div>
            <a href="{{ route('students.byClass', $cls->id) }}" class="btn btn-outline btn-sm" style="margin-top:14px;">
                <i class="fas fa-arrow-right"></i> Xem danh sách
            </a>
        </div>
        @endforeach
    </div>
</div>
@endsection

@section('scripts')
<script>
function showTab(name) {
    document.querySelectorAll('.tab-content').forEach(el => el.classList.remove('active'));
    document.querySelectorAll('.tab').forEach(el => el.classList.remove('active'));
    document.getElementById('tab-' + name).classList.add('active');
    event.target.closest('.tab').classList.add('active');
}
</script>
@endsection
