<?php

namespace App\Http\Controllers\Api\Article;

use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ArticleAllController extends Controller
{
    public function __invoke(Request $request): AnonymousResourceCollection
    {
        $perPage = $request->input('per_page', 10);

        $articles = Article::query()
            ->orderByDesc('published_at')
            ->paginate($perPage);

        return ArticleResource::collection($articles);
    }
}
