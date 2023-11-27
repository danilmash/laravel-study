@extends('layouts.base')
@section('title', 'Комментарии')
@section('content')
<div class="wrapper">
    <table class="table">
    <thead>
        <tr>
        <th scope="col">Date</th>
        <th scope="col">Article Name</th>
        <th scope="col">Text</th>
        <th scope="col"></th>
        </tr>
    </thead>
    <tbody>
    @foreach ($comments as $comment)
        <tr>
        <th scope="row">{{$comment->created_at}}</th>
        @foreach($articles as $article)
        @if ($comment->article_id == $article->id)
        <td><a href="{{route('articles.show', $article)}}">{{$article->title}}</td>
        @endif
        @endforeach
        <td>{{$comment->content}}</td>
        @if($comment->accept == NULL && $comment->accept == 0)
            <td><a href="{{ route('comments.accept', $comment) }}">Accept</a></td>
        @else
            <td><a href="{{ route('comments.reject', $comment) }}">Reject</a></td>
        @endif
        </tr>
    @endforeach
    </tbody>
    </table>
    <div>
      {{$comments->links()}}
    </div>
</div>


@endsection