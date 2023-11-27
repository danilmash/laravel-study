<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Comment;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;
use App\Jobs\VeryLongJob;

class ArticleController extends Controller
{
    public function index()
    {
        // $articles = Article::all(); // Получение всех записей из таблицы articles
        $articles = Article::simplePaginate(10);
        return view('articles.articles_main', ['articles' => $articles]);
    }

    public function create() {
        Gate::authorize('create', [self::class]);
        return view('articles.article_create');
    }

    public function store() {
        $data = request() -> validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);
        $article = Article::create($data);
        VeryLongJob::dispatch($article);
        return redirect()->route('articles');
    }

    public function show(Article $article) {
        if (isset($_GET['notify'])){
            auth()->user()->notifications->where('id', $_GET['notify'])->first()->markAsRead();
        }
        $comments = Comment::where('article_id', $article->id)
                            ->where('accept', 1)
                            ->latest()->simplePaginate(2);
        return view("articles.article", ['article'=>$article, 'comments'=>$comments]);
    }

    public function destroy(Article $article) {
        Gate::authorize('delete', [self::class, $article]);
        $article->delete();

        return redirect()->route('articles');
    }

    public function edit(Article $article) {
        Gate::authorize('update', [self::class, $article]);
        return view("articles.edit", compact("article"));
    }

    public function update(Article $article) {
        request() -> validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);
        $article->title = request() -> get('title', '');
        $article->content = request() -> get('content', '');
        $article->save();
        return redirect()->route('articles');
    }
}
