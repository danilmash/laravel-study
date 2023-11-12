@extends('layouts.base')

@section('title', 'Редактироваие комментария')

@section('content')
<div class="comment-editing">
    <form action="{{ route('comments.update', $comment) }}" method="post">
        @csrf
        @method('put')
        <input type="text" name="content" value="{{$comment->content}}">
        <button type="submit">Сохранить</button>
    </form>
</div>
@endsection
