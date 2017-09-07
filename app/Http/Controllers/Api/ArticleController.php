<?php

namespace App\Http\Controllers\Api;

use App\Article;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArticleController extends Controller
{
    public function store(Request $request)
    {
        $article = Article::create($request->all());

        return response()->json($article, 201);
    }

    public function update(Request $request, Article $article)
    {
        $article->update($request->all());

        return response()->json($article);
    }

    public function destroy(Article $article)
    {
        $article->delete();

        return response()->json(['deleted'], 204);
    }
}
