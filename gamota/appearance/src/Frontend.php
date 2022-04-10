<?php

namespace Gamota\Appearance;

use Illuminate\Database\Eloquent\Model;
use Gamota\Dashboard\Support\Traits\Filter;
use Gamota\Dashboard\Support\Traits\Slug;

class Frontend extends Model
{
    use Filter, Slug;

    protected $table = 'frontend';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'slug',
        'content',
    ];

     /**
     * Các tham số được phép truyền vào từ URL
     *
     * @var array
     */
    protected static $filterable = [
        'id'        => 'integer',
        'name'      => 'max:255',
        'slug'      => 'max:255',

        '_orderby'      => 'in:id,name,created_at,updated_at',
        '_sort'         => 'in:asc,desc',
        '_limit'        => 'integer',
        '_offset'       => 'integer',
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

    public function author()
    {
        return $this->beLongsTo('Gamota\Dashboard\User');
    }

    public function scopeApplyFilter($query, $args = [])
    {
        $args = array_merge(self::$defaultFilter, $args);
        $query->baseFilter($args);
    }

}
