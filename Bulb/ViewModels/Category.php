<?php

namespace Bulb\ViewModels;


use Bulb\App\ViewModel;

class Category extends ViewModel
{
    public $parent = 0;

    public $description = 'Category';

    public function Validate(): bool
    {
        $this->parent = (($this->parent !== null) ? \intval($this->parent) : 0);

        return parent::Validate();
    }

}