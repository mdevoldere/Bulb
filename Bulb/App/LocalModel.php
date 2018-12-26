<?php

namespace Bulb\App;


class LocalModel extends Model
{

    public $id = 0;

    public $key = null;

    public $name = null;

    public $parent = 0;

    public function __construct(array $_values= [])
    {
        if(!empty($_values))
            $this->Update($_values);
    }

    public function Update(array $_values = []) : bool
    {
        foreach ($this as $k => $v)
        {
            if(\array_key_exists($k, $_values))
            {
                $this->{$k} = $_values;
            }
        }

        return $this->IsValid();
    }

    public function IsValid(): bool
    {
        $this->id = \intval($this->id);

        $this->name = Local::Name($this->name);

        if(empty($this->name))
            return false;

        $this->key = \mb_convert_case(Local::Key($this->name), MB_CASE_LOWER);

        $this->parent = (($this->parent !== null) ? \intval($this->parent) : 0);

        return parent::IsValid();
    }
}