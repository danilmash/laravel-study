@extends('layouts.base')

@section('title', 'Статьи')

@section('content')
    <section class="articles-section section">
    <h2 class="section__header">Статьи</h2>
    @foreach ($articles as $article)
                <div class="wrapper">
                    <div class="article">
                        <div class="article__text">
                            <h3 class="article__header">{{ $article->title }}</h3>
                            <p class="article__desc">{{ $article->content }}</p>
                        </div>
                    </div>
                </div>
    @endforeach
    </section>

@endsection
