<?php

namespace Gamota\Dashboard\Support\Traits;

trait Avatar
{
    public function getAvatarAttribute($value)
    {
        if (! empty($value)) {
            return $value;
        }
        
        return setting('default-avatar', upload_url('no-avatar.png'));
    }
}
