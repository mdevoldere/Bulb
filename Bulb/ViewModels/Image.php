<?php

namespace Bulb\ViewModels;


use Bulb\App\ViewModel;

class Image extends ViewModel
{
    public $path;

    public $description = '';

    public function Validate(): bool
    {
        if(empty($this->path))
            return false;

        return parent::Validate();
    }

}