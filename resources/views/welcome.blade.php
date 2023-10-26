@extends('layouts.base')

@section('title', 'Главная')

@section('content')
    <div class="wrapper">
        <div class="first-section section">
            <h1 class="first-section__header section__header">Добро пожаловать на наш сайт!</h1>
            <p class="first-section__text section__text ">Мы предоставляем лучшие услуги для вас.</p>
        </div>
    </div>  
    @if (!empty($data))
    <section class="articles-section section">
    @foreach ($data as $item)
                <div class="wrapper">
                    <div class="article">
                        <a href="{{ route('gallery') }}" class="article__link"><img src="{{ asset('images/' . $item['preview_image']) }}" alt="Картинка-превью" class="article__image"></a>
                        <div class="article__text">
                            <h2 class="article__header">{{$item['name']}}</h2>
                            <p class="article__desc">{{$item['desc']}}</p>
                            <p class="article__date">{{$item['date']}}</p>
                        </div>
                    </div>
                </div>
    @endforeach
    </section>
    @endif

@endsection