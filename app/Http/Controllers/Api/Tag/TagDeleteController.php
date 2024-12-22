<?php

namespace App\Http\Controllers\Api\Tag;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\JsonResponse;
class TagDeleteController extends Controller
{
    public function __invoke(Tag $tag): JsonResponse
    {
        $tag->delete();

        return response()->json([
            'message' => trans('tag.deleted')
        ]);
    }
}
