<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Mail;
use App\Mail\CommentPosted;
use App\Notifications\NotifyNewComment;


class CommentController extends Controller
{
    public function index(){
        $comments = Comment::latest()->simplePaginate(10);
        $articles = Article::all();
        return view('comments.index', ['comments'=>$comments, 'articles'=>$articles]);
    }

    public function accept(Comment $comment){
        Gate::authorize('admincomment');
        $comment->accept = true;
        $comment->save();
        return redirect()->route('comments.get');
    }
    public function reject(Comment $comment){
        Gate::authorize('admincomment');
        $comment->accept = false;
        $comment->save();
        return redirect()->route('comments.get');
    }

    public function store(Article $article, Request $request) {
        $users = User::where('id', '!=', auth()->id())->get();
        $comment = new Comment();
        $comment->article_id = $article->id;
        $comment->content = request() -> get("comment");
        $comment->author_id = Auth::id();
        $res = $comment->save();
        $comments = Comment::where('article_id', $article->id)
                            ->where('accept', 1)
                            ->latest()->simplePaginate(2);
        if ($res) {
            Mail::to('danil.mashentsev@mail.ru')->send(new CommentPosted($article->title, $comment->content));
            \Notification::send($users, new NotifyNewComment($article));
        }
        return view("articles.article", ['article'=>$article, 'comments'=>$comments, 'res'=>$res]);
    }

    public function update(Article $article, Comment $comment) {
        $article = Article::find($comment->article_id);
        $comment->content = request() -> get("content");
        $comment->save();
        $comments = Comment::where('article_id', $article->id)
                            ->where('accept', 1)
                            ->latest()->simplePaginate(2);
        return view("articles.article", ['article'=>$article, 'comments'=>$comments, 'res'=>$res]);
    }

    public function edit(Article $article, Comment $comment) {
        Gate::authorize('comment', $comment);
        return view('articles.edit_comment', compact('comment'));
    }

    public function destroy(Comment $comment) {
        $article = Article::find($comment->article_id);
        Gate::authorize('comment', $comment);
        $comment->delete();
        $comments = Comment::where('article_id', $article->id)
                            ->where('accept', 1)
                            ->latest()->simplePaginate(2);
        return view("articles.article", ['article'=>$article, 'comments'=>$comments, 'res'=>$res]);
    }


}
