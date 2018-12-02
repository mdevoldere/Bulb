<?php

namespace Bulb\Local;


/**
 * Class Collection
 * @package Bulb\Local
 */
class Collection extends Model implements ICollection
{

    /** @var array $items */
    protected $items = [];

    /**
     * Collection constructor.
     * @param string $_name
     * @param Collection $_collection
     */
    public function __construct(string $_name = 'Collection', Collection $_collection = null)
    {
        parent::__construct($_name);

        $this->setCollection($_collection);
    }

    /**
     * @param Collection|null $_collection
     * @return $this
     */
    public function setCollection(Collection $_collection = null)
    {
        if(!empty($_collection))
            $this->updateAll($_collection, false);

        return $this;
    }

    /**
     * @return $this
     */
    public function clear()
    {
        $this->items = [];
        return $this;
    }

    /**
     * @return int
     */
    public function count() : int
    {
        return \count($this->items);
    }


    /**
     * @param string|int $_key
     * @return bool
     */
    public function has($_key) : bool
    {
        if(empty($_key))
            return false;

        if(\array_key_exists($_key, $this->items))
            return true;

        return false;
    }

    /**
     * @param string|int $_pattern
     * @param null|mixed $_filter
     * @return mixed|null
     */
    public function find($_pattern, $_filter = null)
    {
        if($this->has($_pattern))
        {
            if($_filter === null)
                return $this->items[$_pattern];

            if($_filter === $this->items[$_pattern])
                return $this->items[$_pattern];
        }

        return null;
    }

    /**
     * @param null|mixed $_filter
     * @return array
     */
    public function findAll($_filter = null) : array
    {
        try
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
        }
    }

    /**
     * @param string|int|Model $pattern
     * @param null|mixed $filter
     * @param bool $_force
     * @return bool
     */
    public function update($pattern, $filter = null) : bool
    {
        foreach (static::buildFilter($pattern, $filter) as $k => $v)
        {
            $this->items[$pattern] = $filter;
        }


        return true;
    }

    public function remove($_filter = null): bool
    {
        if(!\is_string($_filter) || !\is_int($_filter))
            return false;

        if(\array_key_exists($_filter, $this->items))
            unset($this->items[$_filter]);

        return true;
    }

}