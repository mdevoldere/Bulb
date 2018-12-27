<?php

namespace Bulb\App;


class ModelCollection extends Collection
{

    public function __construct(App $_app, string $_db = 'db')
    {
        $_db = \basename($_db);

        parent::__construct($_app->Cache($_db.'.php'));
    }

    public function GetModel(array $_values = [])
    {
        return new ViewModel($_values);
    }

    public function FindBy(string $_key, $_value = null) : array
    {
        if(empty($_key))
            return [];

        foreach ($this->items as $k => $v)
        {
            if(!\array_key_exists($_key, $v))
                continue;

            if(($v[$_key] === $_value))
                return $this->items[$k];
        }

        return [];
    }

    public function FindKey($_key)
    {
        $_key = Validate::Key($_key);
        //\exporter($_value);
        return $this->FindBy('key', $_key);
    }

    public function FindName($_name)
    {
        $_name = Validate::Name($_name);
        return $this->FindBy('name', $_name);
    }

    public function UpdateItem(array $_item, $_save = true) : ?Model
    {
        $_item = $this->GetModel($_item);

        return $this->UpdateModel($_item, $_save);
    }

    public function UpdateModel(Model $_model, $_save = true) : ?Model
    {
        if($_model->Validate())
        {
            if($_model->id < 1)
                $_model->id = (!empty($this->items) ? (\max(\array_keys($this->items))+1) : 1);

            $this->items[$_model->id] = $_model->FindAll();

            if($_save === true)
                return ($this->Save() > 0) ? $_model : null;

            return $_model;
        }

        return null;
    }


}