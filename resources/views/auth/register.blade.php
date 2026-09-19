@extends('layouts.app')

@section('title', '会員登録')

@section('content')
<div class="mx-auto" style="max-width: 420px;">
    <h1 class="h3 mb-4">会員登録</h1>

    <form action="{{ route('register') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">名前</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required autofocus>
        </div>

        <div class="mb-3">
            <label class="form-label">メールアドレス</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">パスワード</label>
            <input type="password" name="password" class="form-control" required>
            <div class="form-text">8文字以上で入力してください。</div>
        </div>

        <div class="mb-3">
            <label class="form-label">パスワード(確認)</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary w-100">登録する</button>
    </form>

    <p class="mt-3 text-center small">
        既にアカウントをお持ちの方は <a href="{{ route('login') }}">ログイン</a>
    </p>
</div>
@endsection
