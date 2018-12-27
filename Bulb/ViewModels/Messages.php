<?php

namespace Bulb\ViewModels;


use Bulb\App\App;
use Bulb\App\Model;
use Bulb\App\ModelCollection;

class Messages extends ModelCollection
{

    public function __construct(App $_app)
    {
        parent::__construct($_app ,'messages');
        $this->Load();
    }

    public function GetModel(array $_values = [])
    {
        return new Message($_values);
    }

    public function UpdateModel(Model $_model, $_save = true): ?Model
    {
        return (($_model instanceof Message) ? parent::UpdateModel($_model, $_save) : null);
    }

    public function Save() : int
    {
        \krsort($this->items);
        return parent::Save();
    }


}