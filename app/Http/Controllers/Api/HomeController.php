<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;

class HomeController extends Controller
{
    public function index()
    {
        $articles = Article::query()
            ->orderBy('published_at', 'DESC')
            ->paginate(6);

        return response()->json($articles);
    }
}
