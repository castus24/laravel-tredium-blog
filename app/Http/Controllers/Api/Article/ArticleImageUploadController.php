<?php

namespace App\Http\Controllers\Api\Article;

use App\Http\Controllers\Controller;
use App\Http\Requests\ArticlePhotoRequest;
use App\Http\Resources\ArticleShowResource;
use App\Models\Article;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ArticleImageUploadController extends Controller
{
    public function __invoke(ArticlePhotoRequest $request, Article $article): JsonResponse
    {
        /** @var Article $article */
        try {
            $article
                ->addMediaFromRequest('image')
                ->toMediaCollection('article_images', 'public_images');
        } catch (FileDoesNotExist $e) {
            Log::error($e->getMessage());
            return response()->json([
                'message' => trans('article.image.not_exist'),
            ], 422);
        } catch (FileIsTooBig $e) {
            Log::error($e->getMessage());
            return response()->json([
                'message' => trans('article.image.too_big'),
            ], 422);
        }

        return response()->json([
            'message' => trans('article.image.uploaded'),
            'data' => new ArticleShowResource($article)
        ], ResponseAlias::HTTP_OK);
    }
}
