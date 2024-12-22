<?php

namespace App\Http\Controllers\Api\Article;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\JsonResponse;

class ArticleDeleteController extends Controller
{
    public function __invoke(Article $article): JsonResponse
    {
        $article->delete();

        return response()->json([
            'message' => trans('article.deleted')
        ]);
    }
}
