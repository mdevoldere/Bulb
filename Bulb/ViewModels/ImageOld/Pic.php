<?php

namespace Bulb\Models\Image;


use Bulb\App\Model;

class Pic extends Model
{
    public $name;

    public $path;

    public function __construct(?string $_path = null)
    {
        $this->path = \trim($_path);

        $this->name = \basename($_path);
    }
}