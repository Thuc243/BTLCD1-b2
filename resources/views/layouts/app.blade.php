<!DOCTYPE html>
<html>
<head>
    <title>Quản lý sinh viên</title>
</head>
<body>

    <h1>Hệ thống quản lý sinh viên</h1>

    <!-- Thông báo -->
    @if(session('success'))
        <p style="color:green">{{ session('success') }}</p>
    @endif

    @if(session('error'))
        <p style="color:red">{{ session('error') }}</p>
    @endif

    <!-- Lỗi validate -->
    @if($errors->any())
        <ul style="color:red">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <hr>

    @yield('content')

</body>
</html>