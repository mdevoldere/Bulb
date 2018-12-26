<?php

namespace Bulb\App;


class LocalDb extends LocalCollection
{

    protected $model;

    public function __construct(App $_app, string $_db = 'db')
    {
        $_db = \basename($_db);

        parent::__construct($_app->Cache($_db.'.php'));
    }

    public function GetModel(array $_values = [])
    {
        return new LocalModel($_values);
    }

    public function UpdateDbItem(array $_item) : bool
    {
        if(empty($_item['id']))
            $_item['id'] = (!empty($this->items) ? (\max(\array_keys($this->items))+1) : 1);

        $this->model = $this->GetModel($_item);

        if($this->model->IsValid())
        {
            $this->items[$this->model->id] = $this->model->ToArray();
            return true;
        }
    }

    public function ToArrayFull()
    {
        $r = [];

        foreach ($this->ToArray() as $k => $v)
        {
            if(($v['parent'] < 1) && ($v['parent'] !== $v['id']))
            {
                $v['childs'] = $this->FindByParent($v['id']);
            }

            $r[$k] = $v;
        }

        return $r;
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

    public function FindByKey($_value)
    {
        $_value = Local::Key($_value);
        //\exporter($_value);
        return $this->FindBy('key', $_value);
    }

    public function FindByName($_value)
    {
        $_value = Local::Name($_value);
        return $this->FindBy('name', $_value);
    }

    public function FindByParent(int $_parent = 0)
    {
        if(empty($_parent))
            return [];

        $r = [];

        foreach ($this->items as $k => $v)
        {
            if(\array_key_exists('parent', $v))
            {
                if(($v['parent'] === $_parent))
                    $r[$k] = $this->items[$k];
            }

        }

        return $r;
    }
}