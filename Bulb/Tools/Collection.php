<?php

namespace Bulb\Tools;

class Collection
{
   public static function getCollection(Collection $c, $key = null)
   {
        return ((null !== $key) ? $c->get($key) : $c->getItems());
   }

    protected $items = [];

    public function __construct($_collection = null)
    {
        if(null !== $_collection)
        {
            if(\is_array($_collection))
            {
                $this->setItems($_collection);
            }
            elseif(\is_string($_collection))
            {
                //exiter($_collection);
                $this->loadItems($_collection);
            }
        }
    }

    public function clear()
    {
        $this->items = [];
    }

    public function get($key, $default = null)
    {
        return \array_key_exists($key, $this->items) ? $this->items[$key] : $default;
    }

    public function set($key, $value = null)
    {
        $this->items[$key] = $value;
    }

    public function getItems()
    {
        return $this->items;
    }

    public function setItems(array $_collection = [])
    {
        foreach($_collection as $k => $v)
        {
            $this->set($k, $v);
        }

        return $this;
    }

    public function loadItems($path)
    {
        if(\is_file($path))
        {
            return $this->setItems((require $path));
        }
        
        return $this;
    }

    
}