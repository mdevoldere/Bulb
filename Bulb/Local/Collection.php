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

    public function Has($_key = null) : ?string
    {
        $_key = Secure::Key($_key);
        return ((($_key !== null) && \array_key_exists($_key, $this->items)) ? $_key : null);
    }

    public function Find($_key)
    {
        $_key = $this->Has($_key);
        return (($_key !== null) ? $this->items[$_key] : null);
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

        if((null !== ($_item = Secure::Key($_item))))
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

        if(\is_array($_item))
        {
            foreach ($_item as $v)
            {
                $this->Remove($v);
            }
            return true;
        }

        if((null !== ($_item = $this->Has($_item))))
        {
            unset($this->items[$_item]);
            return true;
        }

        return false;
    }

}