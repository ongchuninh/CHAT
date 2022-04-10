<?php

namespace Gamota\News;

use Illuminate\Database\Eloquent\Model;
use Gamota\Dashboard\Support\Traits\Filter;

class NewsToCategory extends Model
{
    protected $table = 'news_to_category';

    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'news_id',
        'category_id',
    ];
}
