<?php

namespace Gamota\Games;

use Illuminate\Database\Eloquent\Model;
use Gamota\Dashboard\Support\Traits\Filter;
use Gamota\Dashboard\Support\Traits\Thumbnail;
use Gamota\Dashboard\Support\Traits\Hierarchical;
use Gamota\Dashboard\Support\Traits\Author;
use Gamota\Dashboard\Support\Traits\Status;
use Gamota\Dashboard\Support\Traits\Slug;

class GameToLanguage extends Model
{
    use Filter, Author, Hierarchical, Status, Thumbnail, Slug;
    
    protected $table = 'game_language';

    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'status',
        'game_id',
        'image',
        'description',
        'gma_id',
        'api_key',
        'game_id',
        'fb_page_id',
        'qr_code',
        'icon',
        'thumbnail',
       
    ];

     /**
     * Các tham số được phép truyền vào từ URL
     *
     * @var array
     */
    protected static $filterable = [
        'id' => '',
        'name' => '',
        
        '_orderby'      => '',//add by Tan
        '_sort'         => 'in:asc,desc',//add by Tan
    ];

    /**
     * Giá trị mặc định của các tham số
     *
     * @var array
     */
    protected static $defaultFilter = [
        
        '_orderby'          => 'updated_at',
        '_sort'             => 'desc',
        'name' => '',
    ];

    protected $searchable = ['id', 'name'];

    public function categories()
    {
        return $this->beLongsToMany('Gamota\Games\GameCategory', 'game_to_category','game_id','category_id');
    }


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