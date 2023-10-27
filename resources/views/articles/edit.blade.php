@extends('layouts.base')

@section('title', 'Редактировать статью')

@section('content')
    <h1>Редактировать статью</h1>

    <form method="post" action="{{ route('articles.update', $article->id) }}">
        @csrf
        @method('put') <!-- Используем метод PUT для обновления -->
        <label for="title">Заголовок:</label>
        <input type="text" name="title" id="title" value="{{ $article->title }}">
        <br>
        <label for="content">Содержимое:</label>
        <textarea name="content" id="content">{{ $article->content }}</textarea>
        <br>
        <button type="submit">Сохранить</button>
        
    </form>
@endsection
