<?php

namespace Gamota\Games;

use Illuminate\Database\Eloquent\Model;
use Gamota\Dashboard\Support\Traits\Filter;
use Gamota\Dashboard\Support\Traits\Thumbnail;
use Gamota\Dashboard\Support\Traits\Hierarchical;
use Gamota\Dashboard\Support\Traits\Author;
use Gamota\Dashboard\Support\Traits\Status;
use Gamota\Dashboard\Support\Traits\Slug;

class GameCategory extends Model
{
    use Filter, Author, Hierarchical, Status, Thumbnail, Slug;
    
    protected $table = 'game_category';

    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'video',
        'image',
        'description',
        'type',
        'status'
    ];

     /**
     * Các tham số được phép truyền vào từ URL
     *
     * @var array
     */
    protected static $filterable = [
        'id' => '',
        'name' => '',
        'status' => 'in:pending,enable,disable',
        'time_status' => 'in:coming,enable,disable',
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
        'name' => '',
    ];

    protected $searchable = ['id', 'name'];

    // public function author()
    // {
    //     return $this->beLongsTo('Gamota\Dashboard\User');
    // }

    public function scopeApplyFilter($query, $args = [])
    {
        $args = array_merge(self::$defaultFilter, $args);
        $query->baseFilter($args);

    }

}