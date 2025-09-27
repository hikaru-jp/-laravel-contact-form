@extends('layouts.header')

@section('content')
    <div class="auth-card">
        <h2 class="page-subtitle">Register</h2>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- お名前 -->
            <div class="form__group">
                <label for="name">お名前</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" autofocus
                    placeholder="例: 山田 太郎">
                @error('name')
                    <p class="form__error">
                        @if ($message === 'The name field is required.')
                            お名前を入力してください
                        @else
                            {{ $message }}
                        @endif
                    </p>
                @enderror
            </div>

            <!-- メールアドレス -->
            <div class="form__group">
                <label for="email">メールアドレス</label>
                <input id="email" type="text" name="email" value="{{ old('email') }}"
                    placeholder="例: test@example.com">
                @error('email')
                    <p class="form__error">
                        @if ($message === 'The email field is required.')
                            メールアドレスを入力してください
                        @elseif ($message === 'The email must be a valid email address.')
                            メールアドレスはメール形式で入力してください
                        @else
                            {{ $message }}
                        @endif
                    </p>
                @enderror
            </div>

            <!-- パスワード -->
            <div class="form__group">
                <label for="password">パスワード</label>
                <input id="password" type="password" name="password" placeholder="例: yourpassword123">
                @error('password')
                    <p class="form__error">
                        @if ($message === 'The password field is required.')
                            パスワードを入力してください
                        @else
                            {{ $message }}
                        @endif
                    </p>
                @enderror
            </div>

            <!-- 登録ボタン -->
            <button type="submit" class="btn-submit">登録</button>
        </form>
    </div>
@endsection
