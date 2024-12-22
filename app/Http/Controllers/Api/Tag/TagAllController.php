<?php

namespace App\Http\Controllers\Api\Tag;

use App\Http\Controllers\Controller;
use App\Http\Resources\TagResource;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

class TagAllController extends Controller
{
    public function __invoke(Request $request): AnonymousResourceCollection
    {
        $perPage = $request->input('per_page', 10);

        return TagResource::collection(
            QueryBuilder::for(Tag::class)
                ->allowedSorts(Tag::getAllowedSorts())
                ->paginate($request->input('itemsPerPage', $perPage))
        );
    }
}
