@extends('layouts.header')

@section('content')
    <div class="auth-card">
        <h2 class="page-subtitle">Login</h2>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- メールアドレス -->
            <div class="form__group">
                <label for="email">メールアドレス</label>
                <input id="email" type="text" name="email" value="{{ old('email') }}" autofocus
                    placeholder="例: test@example.com">
                @error('email')
                    <p class="form__error">
                        @if ($message === 'The email field is required.')
                            メールアドレスを入力してください
                        @elseif ($message === 'The email must be a valid email address.')
                            メールアドレスはメール形式で入力してください
                        @elseif ($message === 'These credentials do not match our records.')
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

            <button type="submit" class="btn-submit">ログイン</button>
        </form>
    </div>
@endsection
