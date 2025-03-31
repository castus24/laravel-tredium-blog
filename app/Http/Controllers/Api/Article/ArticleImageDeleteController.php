<?php

namespace App\Http\Controllers\Api\Article;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ArticleImageDeleteController extends Controller
{
    public function __invoke(Article $article): JsonResponse
    {
        $media = Arr::get($article->getMedia('article_images'), '0');

        if (!$media) {
            return response()->json([
                'message' => trans('article.image.not_found'),
            ], ResponseAlias::HTTP_NOT_FOUND);
        }

        try {
            /** @var Article $media */
            $media->delete();

            return response()->json([
                'message' => trans('article.image.deleted'),
            ], ResponseAlias::HTTP_OK);
        } catch (Exception $e) {
            Log::error($e->getMessage());

            return response()->json([
                'message' => trans('article.image.delete_failed'),
            ], ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
