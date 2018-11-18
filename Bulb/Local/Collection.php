<?php

namespace Bulb\Local;


/**
 * Class Collection
 * @package Bulb\Local
 */
class Collection extends Model
{
    /**
     * @var int $id
     */
    protected $id = 0;

    /**
     * @var string $name
     */
    protected $name;

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

    public function count() : int
    {
        return \count($this->items);
    }

    public function clear()
    {
        $this->items = [];
        return $this;
    }

    /**
     * @param $key
     * @param null $_default
     * @return mixed|null
     */
    public function find($key, $_default = null)
    {
        if(empty($key))
            return $_default;

        if(\array_key_exists($key, $this->items))
            return $this->items[$key];

        foreach ($this->items as $k => $v)
        {
            if (\is_array($v))
            {
                if(\array_key_exists('id', $v) && ($v['id'] === $key))
                    return $v;
                if(\array_key_exists('name', $v) && ($v['name'] === $key))
                    return $v;
            }

            /*if($v === $key)
                return $v;*/
        }

        if($this->masterCollection !== null)
            return $this->masterCollection->find($key, $_default);

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