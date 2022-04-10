<?php

namespace Gamota\Promise;

use Illuminate\Database\Eloquent\Model;
use Gamota\Appearance\Support\Traits\NavigationMenu;
use Gamota\Dashboard\Support\Traits\Thumbnail;
use Gamota\Dashboard\Support\Traits\Filter;
use Gamota\Dashboard\Support\Traits\Status;
use Gamota\Dashboard\Support\Traits\Slug;
use Gamota\Dashboard\Support\Traits\Author;
use Gamota\Dashboard\Support\Traits\Hierarchical;

class Promise extends Model
{
    use Filter, NavigationMenu, Thumbnail, Status, Slug, Author, Hierarchical;
    
    protected $table = 'promise';

    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'phone',
        'email',
        'is_send',
        'ip',
        'gift_code',
    ];

     /**
     * Các tham số được phép truyền vào từ URL
     *
     * @var array
     */
    protected static $filterable = [
        'id'            => 'integer',
        'phone'         => 'max:255',
        'email'         => 'max:255',
        'is_send'         => 'max:255',
        'ip'         => 'max:255',
        'gift_code'         => 'max:255',
        '_orderby' => '',
        '_sort' => 'in:asc,desc',
    ];

    /**
     * Giá trị mặc định của các tham số
     *
     * @var array
     */
    protected static $defaultFilter = [
        '_orderby'      => 'updated_at',
        '_sort'         => 'desc',
    ];

    protected $searchable = ['id', 'phone', 'email'];


    public function scopeApplyFilter($query, $args = [])
    {
        $args = array_merge(self::$defaultFilter, $args);
        $query->baseFilter($args);
        if (! empty($args['phone'])) {
            $query->where('phone', 'like','%'.$args['phone'].'%');
        }
        if (! empty($args['email'])) {
            $query->where('email','like','%'.$args['email'].'%');
        }
    }

}
