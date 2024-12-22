<?php

namespace App\Http\Controllers\Api\Article;

use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleUpdateRequest;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use Illuminate\Http\JsonResponse;

class ArticleUpdateController extends Controller
{
    public function __invoke(ArticleUpdateRequest $request, Article $article): JsonResponse
    {
        $article->update($request->validated());

        return response()->json([
            'message' => trans('article.updated'),
            'data' => new ArticleResource($article)
        ]);
    }
}
