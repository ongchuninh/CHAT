<?php

namespace Gamota\Options;

use Illuminate\Database\Eloquent\Model;
use Gamota\Dashboard\Support\Traits\Filter;
use Gamota\Dashboard\Support\Traits\Thumbnail;
use Gamota\Dashboard\Support\Traits\Hierarchical;
use Gamota\Dashboard\Support\Traits\Author;
use Gamota\Dashboard\Support\Traits\Status;
use Gamota\Dashboard\Support\Traits\Slug;

class Option extends Model
{
    use Filter, Author, Hierarchical, Status, Thumbnail, Slug;
    
    protected $table = 'settings';

    protected $primaryKey = 'id';

    
}