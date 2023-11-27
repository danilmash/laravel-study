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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use App\Mail\CommentPosted;
use App\Notifications\NotifyNewComment;
use App\Events\EventNewComment; 


class CommentController extends Controller
{
    public function index(){
        $page = isset($_GET['page']) ? $_GET['page']: 0;
        $data = Cache::rememberForever('comments'.$page, function (){
        $comments = Comment::latest()->paginate(10);
            $articles = Article::all();
            return [
                'comments'=>$comments,
                'articles'=>$articles,
            ];
        });        
        return view('comments.index', ['comments'=>$data['comments'], 'articles'=>$data['articles']]);
    }

    public function accept(Comment $comment){
        Gate::authorize('admincomment');
        $article = Article::findOrFail($comment->article_id);
        $comment->accept = 1;
        $res = $comment->save();
        if ($res) {
            EventNewComment::dispatch($article);
            $keys = DB::table('cache')->whereRaw('`key` GLOB :key', [':key'=>$article->id.'/comments*[0-9]'])->get();
            foreach($keys as $key){
                Cache::forget($key->key);
            }  
            $keys = DB::table('cache')->whereRaw('`key` GLOB :key', [':key'=>'comments*[0-9]'])->get();
            foreach($keys as $key){
                Cache::forget($key->key);
            }  
        }
        return redirect()->route('comments.get');
    }
    public function reject(Comment $comment){
        Gate::authorize('admincomment');
        $comment->accept = 0;
        $res = $comment->save();
        if ($res){
            $keys = DB::table('cache')->whereRaw('`key` GLOB :key', [':key'=>$comment->article_id.'/comments*[0-9]'])->get();
            foreach($keys as $key){
                Cache::forget($key->key);
            }
            $keys = DB::table('cache')->whereRaw('`key` GLOB :key', [':key'=>'comments*[0-9]'])->get();
            foreach($keys as $key){
                Cache::forget($key->key);
            }
        }
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
            Notification::send($users, new NotifyNewComment($article));
            $keys = DB::table('cache')->whereRaw('`key` GLOB :key', [':key'=>'comments*[0-9]'])->get();
            foreach($keys as $key){
                Cache::forget($key->key);
            }
        }
        return view("articles.article", ['article'=>$article, 'comments'=>$comments, 'res'=>$res]);
    }

    public function update(Article $article, Comment $comment) {
        $article = Article::find($comment->article_id);
        $comment->content = request() -> get("content");
        $res = $comment->save();
        if ($res){
            $keys = DB::table('cache')->whereRaw('`key` GLOB :key', [':key'=>$request->article_id.'/comments*[0-9]'])->get();
            foreach($keys as $key){
                Cache::forget($key->key);
            }
            $keys = DB::table('cache')->whereRaw('`key` GLOB :key', [':key'=>'comments*[0-9]'])->get();
            foreach($keys as $key){
                Cache::forget($key->key);
            }
        }
        $comments = Comment::where('article_id', $article->id)
                            ->where('accept', 1)
                            ->latest()->simplePaginate(2);
        return view("articles.article", ['article'=>$article, 'comments'=>$comments]);
    }

    public function edit(Article $article, Comment $comment) {
        Gate::authorize('comment', $comment);
        return view('articles.edit_comment', compact('comment'));
    }

    public function destroy(Comment $comment) {
        $article = Article::find($comment->article_id);
        Gate::authorize('comment', $comment);
        $res = $comment->delete();
        if ($res){
            $keys = DB::table('cache')->whereRaw('`key` GLOB :key', [':key'=>$article_id.'/comments*[0-9]'])->get();
            foreach($keys as $key){
                Cache::forget($key->key);
            }
            $keys = DB::table('cache')->whereRaw('`key` GLOB :key', [':key'=>'comments*[0-9]'])->get();
            foreach($keys as $key){
                Cache::forget($key->key);
            }
        }
        $comments = Comment::where('article_id', $article->id)
                            ->where('accept', 1)
                            ->latest()->simplePaginate(2);
        return redirect()->route("articles.show", $article);
    }


}
