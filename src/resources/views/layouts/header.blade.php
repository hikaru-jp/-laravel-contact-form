<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FashionablyLate</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    <link rel="stylesheet" href="{{ asset('css/contacts.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <header class="site-header">
        <div class="header-container">
            <!-- ロゴ -->
            <h1 class="logo">FashionablyLate</h1>

            <!-- ナビゲーション -->
            <nav class="nav-links">
            @guest
                @if (request()->routeIs('login'))
                    <a href="{{ route('register') }}" class="btn-nav">Register</a>
                @elseif (request()->routeIs('register'))
                    <a href="{{ route('login') }}" class="btn-nav">Login</a>
                @endif
            @endguest
            </nav>
        </div>
    </header>

    <!-- コンテンツ部分 -->
    <main class="content">
        @yield('content')
    </main>
</body>

</html>
