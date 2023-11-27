@extends('layouts.base')

@section('title', 'Статьи')

@section('content')
    <section class="articles-section section">
        <div class="wrapper">
            @foreach ($articles as $article)
                    <a href="{{ route('articles.show', $article) }}" class="link-to-article">
                        <div class="article" href>
                            <div class="article__text">
                                <h3 class="article__header">{{ $article->title }}</h3>
                                <p class="article__desc">{{ $article->content }}</p>
                                @can('update', $article)
                                <form  method="post" action="{{ route('articles.destroy',  $article)}}">
                                    @csrf
                                    @method("delete")
                                    <button class="article__delete-button" type="submit">X</button>
                                </form>
                                <a class="edit-link" href="{{ route('articles.edit',  $article)}}" >
                                    @csrf
                                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M13 21H21" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M20.0651 7.39423L7.09967 20.4114C6.72438 20.7882 6.21446 21 5.68265 21H4.00383C3.44943 21 3 20.5466 3 19.9922V18.2987C3 17.7696 3.20962 17.2621 3.58297 16.8873L16.5517 3.86681C19.5632 1.34721 22.5747 4.87462 20.0651 7.39423Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M15.3096 5.30981L18.7273 8.72755" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path opacity="0.1" d="M18.556 8.90942L7.09967 20.4114C6.72438 20.7882 6.21446 21 5.68265 21H4.00383C3.44943 21 3 20.5466 3 19.9922V18.2987C3 17.7696 3.20962 17.2621 3.58297 16.8873L15.0647 5.35974C15.0742 5.4062 15.0969 5.45049 15.1329 5.48653L18.5506 8.90426C18.5524 8.90601 18.5542 8.90773 18.556 8.90942Z" fill="currentColor"/>
                                    </svg>
                                </a>
                                @endcan
                            </div>
                        </div>
                    </a>
            @endforeach
        </div>
    </section>
    {{ $articles->links() }}

@endsection
