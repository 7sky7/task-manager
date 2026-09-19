@extends('layouts.app')

@section('title', 'ログイン')

@section('content')
<div class="mx-auto" style="max-width: 420px;">
    <h1 class="h3 mb-4">ログイン</h1>

    <form action="{{ route('login') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">メールアドレス</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus>
        </div>

        <div class="mb-3">
            <label class="form-label">パスワード</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="form-check mb-3">
            <input type="checkbox" name="remember" class="form-check-input" id="remember">
            <label class="form-check-label" for="remember">ログイン状態を保持する</label>
        </div>

        <button type="submit" class="btn btn-primary w-100">ログイン</button>
    </form>

    <p class="mt-3 text-center small">
        アカウントをお持ちでない方は <a href="{{ route('register') }}">会員登録</a>
    </p>

    <div class="alert alert-secondary small mt-4">
        デモ用アカウント: <br>
        Email: <code>demo@example.com</code> / Password: <code>password</code>
    </div>
</div>
@endsection
