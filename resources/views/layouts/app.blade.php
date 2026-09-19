<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'タスク管理')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { min-height: 100vh; }
        .navbar-brand { font-weight: 600; }
    </style>
</head>
<body class="bg-light">

<nav class="navbar navbar-expand navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand" href="{{ route('tasks.index') }}">📝 Task Manager</a>

        @auth
            <div class="d-flex align-items-center gap-3">
                <span class="text-light small">{{ Auth::user()->name }} さん</span>
                <form action="{{ route('logout') }}" method="POST" class="mb-0">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-light">ログアウト</button>
                </form>
            </div>
        @else
            <div class="d-flex gap-2">
                <a href="{{ route('login') }}" class="btn btn-sm btn-outline-light">ログイン</a>
                <a href="{{ route('register') }}" class="btn btn-sm btn-light">会員登録</a>
            </div>
        @endauth
    </div>
</nav>

<div class="container pb-5">
    @include('partials.flash')

    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
