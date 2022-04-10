<?php

namespace Gamota\Links;

use Illuminate\Database\Eloquent\Model;
use Gamota\Dashboard\Support\Traits\Filter;
use Gamota\Dashboard\Support\Traits\Thumbnail;
use Gamota\Dashboard\Support\Traits\SEO;
use Gamota\Dashboard\Support\Traits\Hierarchical;
use Gamota\Dashboard\Support\Traits\Author;
use Gamota\Dashboard\Support\Traits\Status;
use Gamota\Dashboard\Support\Traits\Slug;

class Links extends Model
{
    use Filter, Thumbnail, SEO, Author, Hierarchical, Status, Slug;
    
    protected $table = 'links';

    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'slug',
        'url',
        'target',
        'author_id',
        'status',
    ];

     /**
     * Các tham s? du?c phép truy?n vào t? URL
     *
     * @var array
     */
    protected static $filterable = [
        'id' => '',
        'title' => '',
        'slug' => '',
        'status' => 'in:pending,enable,disable',
        '_orderby' => '',//add by Tan
        '_sort' => 'in:asc,desc',//add by Tan
    ];

    /**
     * Giá tr? m?c d?nh c?a các tham s?
     *
     * @var array
     */
    protected static $defaultFilter = [
        'status'            => 'enable',
        '_orderby'          => 'updated_at',
        '_sort'             => 'desc',
    ];

    protected $searchable = ['id', 'title'];

    public function author()
    {
        return $this->beLongsTo('Gamota\Dashboard\User');
    }

    public function scopeApplyFilter($query, $args = [])
    {
        $args = array_merge(self::$defaultFilter, $args);
        $query->baseFilter($args);

        if (! empty($args['status'])) {
            switch ($args['status']) {
                case 'enable':
                    $query->enable();
                    break;
                
                case 'disable':
                    $query->disable();
                    break;
            }
        }

        if (! empty($args['author_id'])) {
            $query->where('author_id', $args['author_id']);
        }

        if (! empty($args['title'])) {
            $query->where('title', $args['title']);
        }
    }
}
