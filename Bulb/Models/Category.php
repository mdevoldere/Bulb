<?php

namespace Bulb\Models;


use Bulb\Local\Model;

class Category extends Model
{

    public $description;

    public function __construct(?string $_name = null)
    {
        parent::__construct($_name);

    }
}