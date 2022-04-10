<?php

namespace Gamota\Dashboard\Support\Traits;

trait Hierarchical
{
    public function scopeParentAble($query)
    {
        $query->where('id', '!=', $this->id)->where('parent_id', '!=', $this->id);
    }

    public function hasChild()
    {
        return $this->where('parent_id', $this->id)->count() != 0;
    }

    public function setParentIdAttribute($value)
    {
        if ($value) {
            $this->attributes['parent_id'] = $value;
        }
    }
}
