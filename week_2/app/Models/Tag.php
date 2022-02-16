<?php

namespace App\Models;

use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tag extends Model
{
    use HasFactory, Searchable;

    protected $guarded = [];

    public function articles()
    {
        return $this->belongsToMany('App\\Models\\Article', 'articles_tags',);
    }
}
