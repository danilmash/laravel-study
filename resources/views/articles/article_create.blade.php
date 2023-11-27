@extends('layouts.base')

@section('title', 'Редактироваие комментария')

@section('content')
<div>
    <form  class="article-form" action="{{ route('articles.store') }}" method="post">
        @csrf
        <label class="article-form__label" for="title">Заголовок</label>
        <input class="article-form__input" type="text" name="title">
        @error('title')
        <p class="error" >{{ $message }}</p>
        @enderror
        <label class="article-form__label" for="content">Текст</label>
        <textarea class="article-form__textarea" type="text" name="content" maxlength="400"></textarea>
        @error('content')
        <p class="error">{{ $message }}</p>
        @enderror
        <button class="article-form__submit-button" type="submit">Опубликовать</button>
    </form>
</div>

@endsection