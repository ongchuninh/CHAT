<?php

namespace Gamota\News;

use Illuminate\Database\Eloquent\Model;
use Gamota\Dashboard\Support\Traits\Filter;

class News_categories extends Model
{
    protected $table = 'news_categories';

    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'name',
        'thumbnail',
        'parent_id',
        'slug',
        'created_at',
        'updated_at',
    ];
}
