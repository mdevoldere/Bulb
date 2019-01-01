<?php

namespace Bulb\ViewModels;


use Bulb\App\ViewModel;

class Category extends ViewModel
{
    public $parent = 0;

    public $description = 'Category';

    public $cover = '';

    public $pics = [];

    public function Validate(): bool
    {
        $this->parent = (($this->parent !== null) ? \intval($this->parent) : 0);

        if(empty($this->cover) || !\is_string($this->cover))
            $this->cover = '';

        if(empty($this->pics) || !\is_array($this->pics))
            $this->pics = [];

        return parent::Validate();
    }

}