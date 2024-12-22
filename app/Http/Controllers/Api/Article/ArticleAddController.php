<?php

namespace App\Http\Controllers\Api\Article;

use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleAddRequest;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ArticleAddController extends Controller
{
    public function __invoke(ArticleAddRequest $request): JsonResponse
    {
        $article = Article::query()->create($request->validated());

        return response()->json([
            'message' => trans('article.added'),
            'data' => new ArticleResource($article)
            ], ResponseAlias::HTTP_CREATED);
    }
}
