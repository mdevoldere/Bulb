<?php

namespace Bulb\Local;

/**
 * Class Collection
 * @package Bulb\Local
 */
class Collection extends Model
{

    /** @var array $items */
    protected $items = [];


    public function Clear()
    {
        $this->items = [];
        return $this;
    }

    public function Count() : int
    {
        return \count($this->items);
    }

    public function Has($_key) : bool
    {
        return (Model::IsValidKey($_key) && \array_key_exists($_key, $this->items));
    }

    public function Find($_key, $_default = null)
    {
        return ($this->Has($_key) ? $this->items[$_key] : $_default);
    }

    public function FindAll() : array
    {
        return $this->items;
    }

    public function Update($_item, $_value = null) : bool
    {
        if($_item instanceof Collection)
        {
            $_item = $_item->FindAll();
        }
        elseif($_item instanceof Model)
        {
            $_value = $_item;
            $_item = $_item->id;
        }

        if(\is_array($_item))
        {
            foreach ($_item as $k => $v)
            {
                $this->Update($k, $v);
            }
            return true;
        }

        if(Model::IsValidKey($_item))
        {
            $this->items[$_item] = $_value;
            return true;
        }

        return false;
    }

    public function Remove($_item = null): bool
    {
        if($_item instanceof Model)
            $_item = $_item->id;

        if($this->Has($_item))
        {
            unset($this->items[$_item]);
            return true;
        }

        return false;
    }

}