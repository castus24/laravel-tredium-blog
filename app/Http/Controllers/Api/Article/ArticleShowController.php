<?php

namespace App\Http\Controllers\Api\Article;

use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleResource;
use App\Models\Article;

class ArticleShowController extends Controller
{
    public function __invoke(string $slug): ArticleResource
    {
        $article = Article::query()
            ->where('slug', $slug)
            ->first();

        return new ArticleResource($article);
    }
}
