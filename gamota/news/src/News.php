<?php

namespace Gamota\News;

use Illuminate\Database\Eloquent\Model;
use Gamota\Dashboard\Support\Traits\Filter;
use Gamota\Dashboard\Support\Traits\Thumbnail;
use Gamota\Dashboard\Support\Traits\SEO;
use Gamota\Dashboard\Support\Traits\Hierarchical;
use Gamota\Dashboard\Support\Traits\Author;
use Gamota\Dashboard\Support\Traits\Status;
use Gamota\Dashboard\Support\Traits\Slug;

class News extends Model
{
    use Filter, Thumbnail, SEO, Author, Hierarchical, Status, Slug;
    
    protected $table = 'newses';

    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        //'title',
        'slug',
        //'content',
        'sub_content',
        'author_id',
        'status',
        'thumbnail',
        'meta_title',
        'meta_description',
        'meta_keyword',
        'created_at',
        'updated_at',
    ];

     /**
     * Các tham số được phép truyền vào từ URL
     *
     * @var array
     */
    protected static $filterable = [
        'id' => '',
        //'title' => '',
        'status' => 'in:pending,enable,disable',
        'time_status' => 'in:coming,enable,disable',
        'category_id' => 'integer',
        '_orderby' => '',//add by Tan
        '_sort' => 'in:asc,desc',//add by Tan
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
        return $this->beLongsToMany('Gamota\News\Category', 'news_to_category');
    }

    public function author()
    {
        return $this->beLongsTo('Gamota\Dashboard\User');
    }
    public function getInfoLanguage($language_id)
    {
       
        return $this->hasMany('Gamota\News\NewsToLanguage','new_id')->where('language_id',$language_id)->select('id','content','title')->first();
    }

    public function getLanguage()
    {
        
        return $this->hasMany('Gamota\News\NewsToLanguage','new_id');
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
            $query->join('news_to_category', 'newses.id', '=', 'news_to_category.news_id');
            $query->where('news_to_category.category_id', $args['category_id']);
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