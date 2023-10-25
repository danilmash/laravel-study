<!DOCTYPE html>
<html>
<head>
    <title>@yield('title')</title>
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <div class="wrapper">
            <li><a href="{{ route('home')}}">Главная</a></li>
            <li><a href="{{ route('about') }}">О нас</a></li>
            <li><a href="{{ route('contact') }}">Контакты</a></li>
        </div>
    </header>
    <main class="content">
        @yield('content')
    </main>
    <footer>
        <p style="text-align:center; margin-top:200px">Машенцев Данил Николаевич, группы 221-321</p>
    </footer>
</body>
</html>