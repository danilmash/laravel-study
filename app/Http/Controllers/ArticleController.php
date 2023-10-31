<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;

class ArticleController extends Controller
{
    public function index()
    {
        // $articles = Article::all(); // Получение всех записей из таблицы articles
        $articles = Article::simplePaginate(10);
        return view('articles.articles_main', ['articles' => $articles]);
    }

    public function store() {
        $data = request() -> validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        Article::create($data);

        return redirect()->route('articles');
    }

    public function destroy(Article $article) {
        
        $article->delete();

        return redirect()->route('articles');
    }

    public function edit(Article $article) {
        
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
