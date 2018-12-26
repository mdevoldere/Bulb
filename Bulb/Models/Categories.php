<?php


namespace Bulb\Models;


use Bulb\App\App;
use Bulb\App\LocalDb;

class Categories extends LocalDb
{
    public function __construct(App $_app)
    {
        parent::__construct($_app, 'categories');

        $this->Load();
    }

    public function GetModel(array $_values = [])
    {
        return new Category($_values);
    }

}