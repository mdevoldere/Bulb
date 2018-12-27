<?php


namespace Bulb\ViewModels;


use Bulb\App\App;
use Bulb\App\Model;
use Bulb\App\ModelCollection;

class Categories extends ModelCollection
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

    public function UpdateModel(Model $_model, $_save = true): bool
    {
        return (($_model instanceof Category) ? parent::UpdateModel($_model, $_save) : false);
    }

}