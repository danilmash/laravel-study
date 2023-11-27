<!DOCTYPE html>
<html>
<head>
    <title>@yield('title')</title>
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <header>
        <div class="wrapper">
            <ul class="menu">
                <li class="menu__list-item"><a href="{{ route('home')}} @activeLink('/')" class="menu__link link">Главная</a></li>
                <li class="menu__list-item"><a href="{{ route('about') }}" class="menu__link link">О нас</a></li>
                <li class="menu__list-item"><a href="{{ route('contact') }} @activeLink('contacts')" class="menu__link link">Контакты</a></li>
                <li class="menu__list-item"><a href="{{ route('articles') }}" class="menu__link link">Статьи</a></li>
                @can('create')
                <li class="menu__list-item"><a href="{{ route('articles.create') }} @activeLink('articles/create')" class="menu__link link">Создать статью</a></li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('comments.get') }} @activeLink('comments')">Comments <span class="sr-only">(current)</span></a>
                </li>
                @endcan 
                
                @auth
                <li class="menu__list-item">
                    <form action="{{ route('logout') }}" method="post">@csrf
                    <button class="menu__link link">Выйти</button>
                    </form>
                </li>
                <li class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Notifications
                    </button>
                    <div class="dropdown-menu">
                        @foreach(auth()->user()->unreadNotifications as $notification) 
                            <a class="dropdown-item" href="{{route('articles.show', ['article' => $notification->data['article']['id'], 'notify'=>$notification->id])}}">New comment here: {{$notification->data['article']['title']}}</a> 
                        @endforeach    
                    </div>
                </li>
                
                @endauth
            </ul>
        </div>
        <div id="app">
            <App />
        </div>

    </header>
    <main class="content">
        @yield('content')
    </main>
    <footer>
        <p>Машенцев Данил Николаевич, группы 221-321</p>
    </footer>
</body>
</html>
