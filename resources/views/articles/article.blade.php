@extends('layouts.base')

@section('title', 'Просмотр статьи')

@section('content')

<div class="wrapper">
    <div class="article">
        <div class="article__text">
            <h3 class="article__header">{{ $article->title }}</h3>
            <p class="article__desc">{{ $article->content }}</p>
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
        </div>
        <form class="article__comment-form" action="{{ route('comments.store', $article) }}" method="post">
            @csrf
            @method('post')
            <label for="#comment-textarea" hidden>Оставить комментарий</label>
            <textarea placeholder="Оставьте комментарий" class="article__comment-textarea" name="comment" id="comment-textarea" class="article__comment-input" maxlength="200"></textarea>
            <button type="submit" class="article__comment-submit">Комментировать</button>
        </form>
        <div class="article__comments-list">
            <h4 class="article__comments-heading">Комментарии</h4>
            @isset($res)
            @if ($res)
                <div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                     </button>
                    Комментарий успешно добавлен и отправлен на модерацию.
                </div>
            @endif
            @endisset
            @foreach ($comments as $comment)
                <div class="article__comment comment">
                    <p class="comment__content">{{ $comment -> content}}</p>
                    @can('comment', $comment)
                    <a class="comment__edit-link edit-link" href="{{ route('comments.edit', $comment, $article)}}" >
                        @csrf
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M13 21H21" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M20.0651 7.39423L7.09967 20.4114C6.72438 20.7882 6.21446 21 5.68265 21H4.00383C3.44943 21 3 20.5466 3 19.9922V18.2987C3 17.7696 3.20962 17.2621 3.58297 16.8873L16.5517 3.86681C19.5632 1.34721 22.5747 4.87462 20.0651 7.39423Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M15.3096 5.30981L18.7273 8.72755" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path opacity="0.1" d="M18.556 8.90942L7.09967 20.4114C6.72438 20.7882 6.21446 21 5.68265 21H4.00383C3.44943 21 3 20.5466 3 19.9922V18.2987C3 17.7696 3.20962 17.2621 3.58297 16.8873L15.0647 5.35974C15.0742 5.4062 15.0969 5.45049 15.1329 5.48653L18.5506 8.90426C18.5524 8.90601 18.5542 8.90773 18.556 8.90942Z" fill="currentColor"/>
                        </svg>
                    </a>
                    <form method="post" action="{{ route('comments.destroy',  $comment)}}">
                        @csrf
                        @method("delete")
                        <button class="comment__delete-button" type="submit">X</button>
                    </form>
                    @endcan
                </div>
            @endforeach
            <div style="margin: 20px auto; width:fit-content">
                {{$comments->links()}}
            </div>
        </div>
    </div>
</div>
@endsection
