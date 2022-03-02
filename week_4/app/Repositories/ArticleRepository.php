<?php

namespace App\Repositories;

use App\Models\Tag;
use App\Models\Article;
use Illuminate\Http\File;
use App\Models\Attachment;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Pagination\LengthAwarePaginator;

class ArticleRepository
{
    public function __construct(private Article $model)
    {
    }

    public function getListWithPagination(): LengthAwarePaginator
    {
        return $this->model->latest()->with('tags:id,name')->with('love:id,article_id,user_id')->paginate(15);
    }

    public function getOneById(int $id): Article
    {
        return $this->model->with('tags')->where('id', $id)->first();
    }

    public function store(array $params): Article
    {
        return $this->model->create([
            'title' => $params['title'],
            'body' => $params['body'],
            'user_id' => Auth::id(),
        ]);
    }

    public function updateOneByArticle(Article $article, array $params): Article
    {
        $article->update([
            'title' => $params['title'],
            'body' => $params['body'],
        ]);

        return $article;
    }

    public function destroyOneByArticle(Article $article): bool
    {
        return $article->delete();
    }


    public function tagging(Article $article, array $tags): Article
    {
        foreach ($tags as $tag) {
            if (!$tag) continue;
            $createdTag = Tag::firstOrCreate([
                'name' => $tag,
            ]);

            $article->tags[] = $createdTag->makeHidden(['created_at', 'updated_at']);
            $tag_ids[] = $createdTag->id;
        }

        $article->tags()->sync($tag_ids);

        return $article;
    }

    /**
     * @param \App\Models\Article $article 원글
     * @param \Illuminate\Http\UploadedFile $file 첨부파일
     * @param string $store_name 저장path + name
     * @return \App\Models\Article Article에 with attachment 추가
     */
    public function attach(Article $article): Article
    {
        $file = request()->file('attachment');

        $file_path = '/' . date('Ym') . '/' . $article->id;
        $file_name = Auth::id() . date('dHis') . '.' . $file->getClientOriginalExtension();

        Storage::putFileAs('attachment' . $file_path, new File($file->getPathname()), $file_name);

        $attachment = Attachment::create([
            'original_name' => $file->getClientOriginalName(),
            'stored_name' => "{$file_path}/{$file_name}",
            'article_id' => $article->id,
        ]);

        $attachment->makeHidden(['created_at', 'updated_at', 'stored_name', 'article_id']);
        $article->attachment = $attachment;

        return $article;
    }
}