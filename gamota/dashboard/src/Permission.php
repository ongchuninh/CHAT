<?php

namespace Gamota\Dashboard;

use Illuminate\Database\Eloquent\Model;
use Dashboard\Dashboard\Support\Traits\Filter;

class Permission extends Model
{
    public $timestamps = false;

    protected $table = 'permissions';

    protected $primaryKey = 'id';

    protected $fillable = [
        'role_id',
        'permission',
    ];

    public function role()
    {
        return $this->beLongsTo('Gamota\Dashboard\Role');
    }
}
