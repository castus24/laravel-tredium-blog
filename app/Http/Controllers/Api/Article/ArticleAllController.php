<?php

namespace App\Http\Controllers\Api\Article;

use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleShowResource;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

class ArticleAllController extends Controller
{
    public function __invoke(Request $request): AnonymousResourceCollection
    {
        $perPage = $request->input('per_page', 10);

        return ArticleShowResource::collection(
            QueryBuilder::for(Article::class)
                ->allowedFilters(Article::getAllowedFilters())
                ->allowedSorts(Article::getAllowedSorts())
                ->paginate($request->input('itemsPerPage', $perPage))
        );
    }
}
