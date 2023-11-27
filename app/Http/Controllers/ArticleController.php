<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Comment;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Jobs\VeryLongJob;
use App\Events\EventNewComment;

class ArticleController extends Controller
{
    public function index()
    {
        // $articles = Article::all(); // Получение всех записей из таблицы articles
        $page = isset($_GET['page']) ? $_GET['page']: 0;
        $articles = Cache::remember('articles'.$page, 3000, function(){
            return Article::latest()->paginate(5);
        });
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
        if ($article){
            VerylongJob::dispatch($article);
            $keys = DB::table('cache')->whereRaw('`key` GLOB :key', [':key'=>'articles*[0-9]'])->get();
            foreach($keys as $key){
                Cache::forget($key->key);
            }            
        }
        return view('articles.article_create');
    }

    public function show(Article $article) {
        if (isset($_GET['notify'])){
            auth()->user()->notifications->where('id', $_GET['notify'])->first()->markAsRead();
        }
        $page = isset($_GET['page']) ? ($_GET['page']) : 0;
        $comments = Cache::rememberForever($article->id.'/comments'.$page,function()use($article){
            return Comment::where('article_id', $article->id)
                            ->where('accept', 1)
                            ->latest()->simplePaginate(2);});
        return view("articles.article", ['article'=>$article, 'comments'=>$comments]);
    }

    public function destroy(Article $article) {
        Gate::authorize('delete', [self::class, $article]);
        $res = $article->delete();
        if ($res){
            $keys = DB::table('cache')->whereRaw('`key` GLOB :key', [':key'=>$article->id.'/comments*[0-9]'])->get();
            foreach($keys as $key){
                Cache::forget($key->key);
            }
            $keys = DB::table('cache')->whereRaw('`key` GLOB :key', [':key'=>'articles*[0-9]'])->get();
            foreach($keys as $key){
                Cache::forget($key->key);
            }
            $keys = DB::table('cache')->whereRaw('`key` GLOB :key', [':key'=>'comments*[0-9]'])->get();
            foreach($keys as $key){
                Cache::forget($key->key);
            }
        };

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
        $res = $article->save();
        if ($res){
            $keys = DB::table('cache')->whereRaw('`key` GLOB :key', [':key'=>$article->id.'/comments*[0-9]'])->get();
            foreach($keys as $key){
                Cache::forget($key->key);
            }
            $keys = DB::table('cache')->whereRaw('`key` GLOB :key', [':key'=>'articles*[0-9]'])->get();
            foreach($keys as $key){
                Cache::forget($key->key);
            }
        };
        return redirect()->route('articles');
    }
}
