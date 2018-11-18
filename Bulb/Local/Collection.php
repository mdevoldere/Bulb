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

    /** @var null|IModel */
    protected $masterCollection = null;

    /**
     * Collection constructor.
     * @param string $_name
     */
    public function __construct(string $_name = 'Collection')
    {
        parent::__construct(0, $_name);
    }

    /**
     * @param IModel|null $_masterCollection
     * @return $this
     */
    public function setMasterCollection(IModel $_masterCollection = null)
    {
        $this->masterCollection = $_masterCollection;
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
     * @return $this
     */
    public function clear()
    {
        $this->items = [];
        return $this;
    }

    /**
     * @param $key
     * @param null $loadAsCollection
     * @return mixed|null
     */
    public function find($key, $loadAsCollection = null)
    {
        if(\array_key_exists($key, $this->items))
            return $this->items[$key];

        if($this->masterCollection !== null)
            return $this->masterCollection->find($key, $loadAsCollection);

        return $loadAsCollection;
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
     * @param $key
     * @param null $value
     * @param bool $_force
     * @return bool
     */
    public function update($key, $value = null, bool $_force = true) : bool
    {
        if(($_force === false) && \array_key_exists($key, $this->items))
            return false;

        $this->items[$key] = $value;
        //exporter($this, '44');

        return true;
    }

}