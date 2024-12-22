<?php

namespace App\Http\Controllers\Api\Tag;

use App\Http\Controllers\Controller;
use App\Http\Requests\TagRequest;
use App\Http\Resources\TagResource;
use App\Models\Tag;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class TagAddController extends Controller
{
    public function __invoke(TagRequest $request): JsonResponse
    {
        $tag = Tag::query()->create($request->validated());

        return response()->json([
            'message' => trans('tag.added'),
            'data' => new TagResource($tag)
            ], ResponseAlias::HTTP_CREATED);
    }
}
