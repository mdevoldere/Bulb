<?php

namespace Bulb\Local;


/**
 * Class Collection
 * @package Bulb\Local
 */
class Collection
{

    /** @var array $items */
    protected $items = [];

    /**
     * Collection constructor.
     */
    public function __construct()
    {

    }


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
        if(empty($_key))
            return false;

        if((\is_string($_key) || is_int($_key) && \array_key_exists($_key, $this->items)))
            return true;

        return false;
    }


    public function Find($_key, $_default = null)
    {
        if((\is_string($_key) || is_int($_key)) && \array_key_exists($_key, $this->items))
        {
            return $this->items[$_key];
        }

        return $_default;
    }


    public function FindAll($_filter = null) : array
    {
        return $this->items;


       /* try
        {
            if(empty($_filter))
                return $this->items;

            if(\is_string($_filter))
            {
                if(\substr($_filter, 0, 1) === '{')
                    $_filter = \json_decode($_filter, true);
            }

            if(!\is_array($_filter))
                $_filter = [];

            $r = [];

            foreach ($_filter as $k => $v)
            {
                if(\array_key_exists($k, $this->items))
                {
                    if($v === $this->items[$k])
                    {
                        $r[$k] = $v;
                    }
                }
            }

            return $r;
        }
        catch(\Exception $e)
        {
            \trigger_error($e->getMessage());
        }*/
    }



    public function Update($_item, $_value = null) : bool
    {
        if(empty($_item))
            return false;

        if($_item instanceof Model)
        {
            $_value = $_item;
            $_item = $_item->Id();
        }
        elseif ($_item instanceof Collection)
        {
            $_item = $_item->findAll();
        }

        if(\is_array($_item))
        {
            foreach ($_item as $k => $v)
            {
                $this->Update($k, $v);
            }
            return true;
        }

        if(!\is_string($_item) && !\is_int($_item))
            return false;

        $this->items[$_item] = $_value;

        return true;
    }

    public function Remove($_item = null): bool
    {
        if($_item instanceof Model)
            $_item = $_item->Id();

        if(empty($_item) || !\is_string($_item) || !\is_int($_item))
            return false;

        if(\array_key_exists($_item, $this->items))
        {
            unset($this->items[$_item]);
            return true;
        }

        return false;
    }

}