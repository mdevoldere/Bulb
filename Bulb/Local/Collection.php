<?php


namespace Bulb\Local;


class Collection
{
    /** @var array $items */
    protected $items = [];

    /** @var null|Collection */
    protected $masterCollection = null;

    /**
     * @param Collection|null $_masterCollection
     * @return $this
     */
    public function setMasterCollection(Collection $_masterCollection = null)
    {
        $this->masterCollection = $_masterCollection;
        return $this;
    }

    /**
     * Collection constructor.
     * @param array $_collection
     */
    public function __construct($_collection = [])
    {
        if(!empty($_collection))
            $this->updateAll($_collection);
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
     * @param null $default
     * @return mixed|null
     */
    public function find($key, $default = null)
    {
        if(\array_key_exists($key, $this->items))
            return $this->items[$key];

        if($this->masterCollection !== null)
            return $this->masterCollection->find($key, $default);

        return $default;
    }

    /**
     * @param bool $_includeMaster
     * @return array
     */
    public function findAll(bool $_includeMaster = true): array
    {
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
     * @return $this
     */
    public function update($key, $value = null, bool $_force = true)
    {
        if(($_force === false) && \array_key_exists($key, $this->items))
            return $this;

        $this->items[$key] = $value;

        return $this;
    }

    /**
     * @param array|Collection $_collection
     * @param bool $_force
     * @return $this
     */
    public function updateAll($_collection = [], bool $_force = true)
    {
        if($_collection instanceof Collection)
            $_collection = $_collection->findAll();

        if(\is_array($_collection))
        {
            foreach($_collection as $k => $v)
            {
                $this->update($k, $v, $_force);
            }
        }

        return $this;
    }

}