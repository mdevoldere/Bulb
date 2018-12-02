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

    public function find($_pattern, $_filter = null)
    {
        if(empty($_pattern))
            return $_filter;

        if(\array_key_exists($_pattern, $this->items))
            return $this->items[$_pattern];

        foreach ($this->items as $k => $v)
        {
            if($_pattern === $v->getId())
                return $v;
            if($_pattern === $v->getName())
                return $v;
        }

        foreach ($this->items as $k => $v)
        {
            if($v instanceof Collection)
            {
                if(null !== ($f = $v->find($_pattern)))
                    return $f;
            }
        }

        return $_filter;
    }

    public function findAll($_filter = null): array
    {
        return $this->items;
    }

    public function update($pattern, $filter = null, bool $_force = true): bool
    {
        if($filter instanceof IModel)
            $pattern = $filter;

        if(!$pattern instanceof IModel)
            return false;



        if(!$pattern->isRegistered())
        {
            if($this->count() > 0)
                $pattern->setId(\max(\array_keys($this->items))+1);
            else
                $pattern->setId(1);
        }

        $filter = $pattern;
        $pattern = $filter->getId();

        return parent::update($pattern, $filter, $_force);
    }


}