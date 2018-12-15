<?php

namespace Bulb\Local;

/**
 * Class Model
 * @package Bulb\Local
 * @see \Bulb\Local\IModel
 */
class Model
{
    /**
     * @var string|int $id
     */
    protected $id;

    /**
     * Base Model
     * @param int|string $_id
     */
    public function __construct($_id = null)
    {
        $this->Id($_id);
    }

    public function Id($_id = null)
    {
        if(!empty($_id) && (\is_string($_id) || \is_int($_id)))
            $this->id = $_id;

        return $this->id;
    }

    public function IsValid() : bool
    {
        return !empty($this->id);
    }

    public function ToArray() : array
    {
        return \get_object_vars($this);
    }

    public function ToString() : string
    {
        $s = (\basename(\get_called_class()).'::'.$this->id."\n");

        foreach ($this->ToArray() as $k => $v)
        {
            if(\is_string($v) || \is_numeric($v))
                $s .= ($k.': '.$v."\n");
        }

        return $s;
    }
}