@extends('layouts.app')
@section('title', 'Đăng ký môn học - ' . $student->student_name)

@section('content')
<div class="breadcrumb">
    <a href="{{ route('students.index') }}">Dashboard</a>
    <i class="fas fa-chevron-right" style="font-size:10px"></i>
    <a href="{{ route('students.show', $student->id) }}">{{ $student->student_name }}</a>
    <i class="fas fa-chevron-right" style="font-size:10px"></i>
    <span>Đăng ký môn học</span>
</div>

<div class="page-header animate-in">
    <h1><i class="fas fa-plus-circle"></i> Đăng ký môn học</h1>
    <p>Bài 6: Repository::registerSubject() – {{ $student->student_name }}</p>
</div>

<div class="card animate-in">
    <div class="card-header">
        <div class="card-title"><i class="fas fa-plus-circle"></i> Chọn môn học để đăng ký</div>
    </div>

    <div class="code-block">
        <pre><span class="comment">// Bài 6: Repository - registerSubject()</span>
<span class="keyword">public function</span> <span class="method">registerSubject</span>($studentId, $subjectId)
{
    $student = Student::<span class="method">findOrFail</span>($studentId);
    $student-><span class="method">subjects</span>()-><span class="method">syncWithoutDetaching</span>([
        $subjectId => [<span class="string">'registered_at'</span> => Carbon::<span class="method">now</span>()]
    ]);
    <span class="keyword">return</span> $student-><span class="method">load</span>(<span class="string">'subjects'</span>);
}</pre>
    </div>

    <form action="{{ route('students.registerSubject', $student->id) }}" method="POST">
        @csrf
        <div class="form-group">
            <label class="form-label">Chọn môn học</label>
            <select name="subject_id" class="form-select" required>
                <option value="">-- Chọn môn học --</option>
                @foreach($subjects as $sub)
                    @if(!in_array($sub->id, $registeredIds))
                        <option value="{{ $sub->id }}">{{ $sub->subject_name }}</option>
                    @endif
                @endforeach
            </select>
        </div>
        <div style="display:flex;gap:10px;">
            <button type="submit" class="btn btn-primary"><i class="fas fa-check"></i> Đăng ký</button>
            <a href="{{ route('students.show', $student->id) }}" class="btn btn-outline">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>
        </div>
    </form>
</div>

<!-- Môn đã ĐK -->
<div class="card animate-in">
    <div class="card-header">
        <div class="card-title"><i class="fas fa-check-circle"></i> Môn đã đăng ký ({{ count($registeredIds) }})</div>
    </div>
    <div class="table-wrapper">
        <table>
            <thead><tr><th>ID</th><th>Tên môn</th><th>Trạng thái</th></tr></thead>
            <tbody>
                @foreach($subjects as $sub)
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
                        @if(in_array($sub->id, $registeredIds))
                            <span class="badge badge-success"><i class="fas fa-check"></i> Đã đăng ký</span>
                        @else
                            <span class="badge badge-warning"><i class="fas fa-minus"></i> Chưa đăng ký</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
