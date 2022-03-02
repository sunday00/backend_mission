<?php

namespace App\Contracts;

use App\Models\Article;
use App\Contracts\ArticleInterface;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

abstract class AbstractArticleService implements ArticleInterface
{
    public function createForm(): View | RedirectResponse
    {
        return view();
    }

    public function editForm(Article $article): View | RedirectResponse
    {
        return view();
    }
}