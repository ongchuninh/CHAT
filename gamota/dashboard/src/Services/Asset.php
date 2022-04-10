<?php

namespace Gamota\Dashboard\Services;

use Gamota\Dashboard\Support\AssetLocation;
use Illuminate\Support\Collection;

class Asset
{
    protected $locations = [];

    public function render()
    {
        foreach ($this->locations as $location) {
            $location->render();
        }
    }

    public function where($location)
    {
        if (!isset($this->locations[$location])) {
            $this->locations[$location] = new AssetLocation();
        }

        return $this->locations[$location];
    }
}