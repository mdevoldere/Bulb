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

    /** @var null|Collection */
    protected $masterCollection = null;

    /**
     * Collection constructor.
     * @param string $_name
     * @param Collection $_masterCollection
     */
    public function __construct(string $_name = 'Collection', Collection $_masterCollection = null)
    {
        parent::__construct($_name);
        $this->masterCollection = $_masterCollection;
    }

    /**
     * @param Collection|null $masterCollection
     */
    public function setMasterCollection(Collection $masterCollection = null)
    {
        $this->masterCollection = $masterCollection;
    }

    /**
     * @return int
     */
    public function count() : int
    {
        return \count($this->items);
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
     * @param string $_key
     * @return bool
     */
    public function has($_key) : bool
    {
        if(empty($_key) || !\is_string($_key))
            return false;

        if(!\array_key_exists($_key, $this->items))
            return false;

        return true;
    }

    /**
     * @param $_key
     * @param null $_default
     * @return mixed|null
     */
    public function find($_key, $_default = null)
    {
        if($this->has($_key))
            return $this->items[$_key];

        if($this->masterCollection !== null)
            return $this->masterCollection->find($_key, $_default);

        return $_default;
    }

    /**
     * @param null|mixed $_includeMaster
     * @return array
     */
    public function findAll($_includeMaster = null) : array
    {
        if($_includeMaster === null)
            $_includeMaster = true;

        if(($_includeMaster === true) && ($this->masterCollection !== null))
        {
            $r = $this->items;

            foreach ($this->masterCollection->findAll($_includeMaster) as $k => $v)
            {
                if(!\array_key_exists($k, $r))
                {
                    $r[$k] = $v;
                }
            }

            return $r;
        }

        return $this->items;
    }

    /**
     * @param string|int|Model $key
     * @param null|mixed $value
     * @param bool $_force
     * @return bool
     */
    public function update($key, $value = null, bool $_force = true) : bool
    {
        if(($_force === false) && (null !== $this->find($key)))
            return false;

        $this->items[$key] = $value;

        return true;
    }

    public function delete($_filter = null): bool
    {
        if(!\is_string($_filter) || !\is_int($_filter))
            return false;

        if(\array_key_exists($_filter, $this->items))
            unset($this->items[$_filter]);

        return true;
    }

}