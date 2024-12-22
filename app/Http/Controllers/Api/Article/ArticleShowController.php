<?php

namespace App\Http\Controllers\Api\Article;

use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use Illuminate\Http\JsonResponse;

class ArticleShowController extends Controller
{
    public function __invoke(Article $article): JsonResponse
    {
        return response()->json([
           'data' => new ArticleResource($article)
        ]);
    }
}
