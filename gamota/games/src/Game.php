<?php

namespace Gamota\Games;

use Illuminate\Database\Eloquent\Model;
use Gamota\Dashboard\Support\Traits\Filter;
use Gamota\Dashboard\Support\Traits\Thumbnail;
use Gamota\Dashboard\Support\Traits\Hierarchical;
use Gamota\Dashboard\Support\Traits\Author;
use Gamota\Dashboard\Support\Traits\Status;
use Gamota\Dashboard\Support\Traits\Slug;

class Game extends Model
{
    
    use Filter, Thumbnail, Author, Hierarchical, Status, Slug;
    
    protected $table = 'games';

    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'game_id',
        'gma_id',
        'api_key',
        'game_id',
        'link',
        'fb_page_id',
        'qr_code',
        'icon',
        'total_play',
        'status',
        'display',
        'thumbnail',
        'thumbnail_lg'
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

    protected $searchable = ['id', 'status'];

    public function categories()
    {
        return $this->beLongsToMany('Gamota\Games\GameCategory', 'game_to_category','game_id','category_id');
    }

    public function getInfoLanguage($language_id)
    {
        //return $this->hasMany('Gamota\Games\GameCategory', 'game_to_category','game_id','category_id');
        return $this->hasMany('Gamota\Games\GameToLanguage','game_id')->where('language_id',$language_id)->select('id','name','description')->first();
    }

    public function getLanguage()
    {
        //return $this->hasMany('Gamota\Games\GameCategory', 'game_to_category','game_id','category_id');
        return $this->hasMany('Gamota\Games\GameToLanguage','game_id');
    }


    // public function author()
    // {
    //     return $this->beLongsTo('Gamota\Dashboard\User');
    // }

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

        if (! empty($args['name'])) {
            $query->join('game_language', 'games.id', '=', 'game_language.game_id');
            $query->where('game_language.name','like', '%'.$args['name'].'%');
            $query->groupBy('game_language.game_id');
            $query->select('games.*','game_language.name as name');
        }

    }

}