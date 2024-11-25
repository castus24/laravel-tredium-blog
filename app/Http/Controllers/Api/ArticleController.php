<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::query()
            ->orderBy('published_at', 'DESC')
            ->paginate(10);

        return response()->json($articles);
    }

    public function show(string $slug)
    {
        $article = Article::query()
            ->where('slug', $slug)
            ->first();

        return response()->json($article);
    }

    public function storeComment($subject, $message)
    {
//        $comment = Comment::query()->create([
//            'article_id' => '',
//            'user_id' => '',
//            'subject' => $subject,
//            'message' => $message,
//        ]);
    }
}
