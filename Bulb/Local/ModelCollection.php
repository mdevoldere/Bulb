<?php

namespace Bulb\Local;


class ModelCollection extends Collection
{
    /**
     * @var int $id
     */
    protected $id = 0;

    /**
     * @var string $name
     */
    protected $name;

    /** @var IModel[] $items */
    protected $items = [];

    public function __construct($_name = 'Collection')
    {
        parent::__construct($_name, null);
    }

    public function find($key, $_default = null)
    {
        if(empty($key))
            return $_default;

        if(\array_key_exists($key, $this->items))
            return $this->items[$key];

        foreach ($this->items as $k => $v)
        {
            if($key === $v->getId())
                return $v;
            if($key === $v->getName())
                return $v;

            if($v instanceof Collection)
            {
                if(null !== ($f = $v->find($key)))
                    return $f;
            }
        }

        foreach ($this->items as $k => $v)
        {
            if($v instanceof Collection)
            {
                if(null !== ($f = $v->find($key)))
                    return $f;
            }
        }

        return $_default;
    }

    public function findAll($_includeMaster = null): array
    {
        return $this->items;
    }

    public function update($key, $value = null, bool $_force = true): bool
    {
        if($value instanceof IModel)
            $key = $value;

        if(!$key instanceof IModel)
            return false;



        if(!$key->isRegistered())
        {
            if($this->count() > 0)
                $key->setId(\max(\array_keys($this->items))+1);
            else
                $key->setId(1);
        }

        $value = $key;
        $key = $value->getId();

        return parent::update($key, $value, $_force);
    }


}