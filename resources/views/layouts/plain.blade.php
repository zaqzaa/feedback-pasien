<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name', 'Laravel'))</title>
    <style>
        body{font-family:Inter, system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial; margin:0; background:#f6f7f8; color:#111}
        .page-wrap{min-height:100vh;display:flex;align-items:flex-start;justify-content:center;padding:28px}
        .container{width:100%;max-width:900px}
    </style>
    @yield('styles')
</head>
<body>
    <div class="page-wrap">
        <div class="container">
            @yield('content')
        </div>
    </div>
</body>
</html>
