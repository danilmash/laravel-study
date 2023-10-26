<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::all(); // Получение всех записей из таблицы articles
        return view('articles.articles_main', ['articles' => $articles]);
    }

    
}
