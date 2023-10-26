<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;

class ArticleController extends Controller
{
    public function index()
    {
        // $articles = Article::all(); // Получение всех записей из таблицы articles
        $articles = Article::paginate(10);
        return view('articles.articles_main', ['articles' => $articles]);
    }

    public function create(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        Article::create($data);

        return redirect()->route('articles');
    }
}
