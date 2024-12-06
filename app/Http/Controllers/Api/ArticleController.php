<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleResource;
use App\Models\Article;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::query()
            ->orderByDesc('published_at')
            ->paginate(10);

        return ArticleResource::collection($articles);
    }

    public function show(string $slug)
    {
        $article = Article::query()
            ->where('slug', $slug)
            ->first();

        return new ArticleResource($article);
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
