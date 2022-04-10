<?php

namespace Gamota\Gallery;

use Illuminate\Database\Eloquent\Model;
use Gamota\Dashboard\Support\Traits\Filter;
use Gamota\Dashboard\Support\Traits\Thumbnail;
use Gamota\Dashboard\Support\Traits\Hierarchical;
use Gamota\Dashboard\Support\Traits\Author;
use Gamota\Dashboard\Support\Traits\Status;
use Gamota\Dashboard\Support\Traits\Slug;

class Gallery extends Model
{
    use Filter, Thumbnail, Author, Hierarchical, Status, Slug;
    
    protected $table = 'gallery';

    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'slug',
        'author_id',
        'status',
        'youtube_id',
        'thumbnail',
    ];

     /**
     * Các tham số được phép truyền vào từ URL
     *
     * @var array
     */
    protected static $filterable = [
        'id' => '',
        'title' => '',
        'youtube_id' => '',
        'status' => 'in:pending,enable,disable',
        'time_status' => 'in:coming,enable,disable',
        'category_id' => 'integer',
        '_orderby'      => '',//add by Tan
        '_sort'         => 'in:asc,desc',//add by Tan
    ];

    /**
     * Giá trị mặc định của các tham số
     *
     * @var array
     */
    protected static $defaultFilter = [
        'status'            => 'enable',
        '_orderby'          => 'updated_at',
        '_sort'             => 'desc',
    ];

    protected $searchable = ['id', 'title'];

    public function categories()
    {
        return $this->beLongsToMany('Gamota\Gallery\Category', 'gallery_to_category');
    }

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

        if (! empty($args['category_id'])) {
            $query->join('gallery_to_category', 'gallery.id', '=', 'gallery_to_category.gallery_id');
            $query->where('gallery_to_category.category_id', $args['category_id']);
        }
    }

    public function getSubContentAttribute($value)
    {
        if (!empty($value)) {
            return $value;
        }

        if (!empty($this->content)) {
            return str_limit(strip_tags($this->content), 150);
        }

        return null;
    }
}
