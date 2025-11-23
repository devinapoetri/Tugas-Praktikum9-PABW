<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initialscale=1.0">
    <title>Identitas Mahasiswa- @yield('title')</title>
    {{-- @yield untuk data dinamis dan dihubungkan ke title views lain --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min
.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-4">
        @yield('content')
        {{-- @yield untuk data dinamis dan dihubungkan ke isi konten views lain --}}
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
