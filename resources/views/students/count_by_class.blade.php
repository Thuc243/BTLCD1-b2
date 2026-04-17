@extends('layouts.app')
@section('title', 'Bài 4.3 – Đếm SV theo lớp')

@section('content')
<div class="breadcrumb">
    <a href="{{ route('students.index') }}">Dashboard</a>
    <i class="fas fa-chevron-right" style="font-size:10px"></i>
    <span>Bài 4.3 – Đếm sinh viên theo lớp</span>
</div>

<div class="page-header animate-in">
    <h1><i class="fas fa-chart-bar"></i> Đếm số sinh viên theo từng lớp</h1>
    <p>Bài 4.3 – Sử dụng Eloquent withCount và Query Builder GROUP BY</p>
</div>

<!-- Cách 1: Eloquent withCount -->
<div class="card animate-in">
    <div class="card-header">
        <div class="card-title"><i class="fas fa-magic"></i> Cách 1: Eloquent withCount</div>
    </div>

    <div class="code-block">
        <pre><span class="comment">// Eloquent: withCount</span>
$classrooms = Classroom::<span class="method">withCount</span>(<span class="string">'students'</span>)-><span class="method">get</span>();</pre>
    </div>

    <div class="stats-grid">
        @foreach($classrooms as $cls)
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-chalkboard"></i></div>
            <div class="stat-number">{{ $cls->students_count }}</div>
            <div class="stat-label">{{ $cls->class_name }}</div>
        </div>
        @endforeach
    </div>

    <div class="table-wrapper">
        <table>
            <thead><tr><th>ID Lớp</th><th>Tên lớp</th><th>Số sinh viên</th></tr></thead>
            <tbody>
                @foreach($classrooms as $cls)
                <tr>
                    <td><strong>#{{ $cls->id }}</strong></td>
                    <td><span class="badge badge-accent">{{ $cls->class_name }}</span></td>
                    <td><span class="badge badge-primary">{{ $cls->students_count }} SV</span></td>
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
    </div>

    <div class="code-block">
        <pre><span class="comment">// Query Builder: LEFT JOIN + GROUP BY</span>
$classrooms = DB::<span class="method">table</span>(<span class="string">'classrooms'</span>)
    -><span class="method">leftJoin</span>(<span class="string">'students'</span>, <span class="string">'classrooms.id'</span>, <span class="string">'='</span>, <span class="string">'students.class_id'</span>)
    -><span class="method">select</span>(<span class="string">'classrooms.id'</span>, <span class="string">'classrooms.class_name'</span>,
        DB::<span class="method">raw</span>(<span class="string">'COUNT(students.id) as students_count'</span>))
    -><span class="method">groupBy</span>(<span class="string">'classrooms.id'</span>, <span class="string">'classrooms.class_name'</span>)
    -><span class="method">get</span>();</pre>
    </div>

    <div class="table-wrapper">
        <table>
            <thead><tr><th>ID Lớp</th><th>Tên lớp</th><th>Số sinh viên</th></tr></thead>
            <tbody>
                @foreach($classroomsQB as $cls)
                <tr>
                    <td><strong>#{{ $cls->id }}</strong></td>
                    <td><span class="badge badge-accent">{{ $cls->class_name }}</span></td>
                    <td><span class="badge badge-warning">{{ $cls->students_count }} SV</span></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
