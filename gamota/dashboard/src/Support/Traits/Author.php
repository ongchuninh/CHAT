<?php

namespace Gamota\Dashboard\Support\Traits;

use Gamota\Dashboard\User;

trait Author
{
    public function setAuthorIdAttribute($value)
    {
        if (User::where('id', $value)->exists()) {
            $this->attributes['author_id'] = $value;
        } else {
            $this->attributes['author_id'] = User::first()->id;
        }
    }
}
