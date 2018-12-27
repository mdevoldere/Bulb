<?php

namespace Bulb\App;

/**
 * Class Model
 * @package Bulb\App
 */
abstract class Model
{
    /**
     * Model Unique ID
     * @var int $id
     */
    public $id;

    /**
     * Base Model
     * @param array|Model $_values
     */
    public function __construct($_values = [])
    {
        $this->id = 0;

        if(!empty($_values))
            $this->Update($_values);
    }

    /** Get Model items 'as it'
     * @return array
     */
    public function FindAll() : array
    {
        return \get_object_vars($this);
    }

    /**
     * @param array|Model $_item
     * @return bool
     */
    public function Update($_item) : bool
    {
        if($_item instanceof Model)
            $_item = $_item->FindAll();

        if(!empty($_item) && \is_array($_item))
        {
            foreach ($this as $k => $v)
            {
                if(\array_key_exists($k, $_item))
                {
                    $this->{$k} = $_item[$k];
                }
            }

            return true;
        }

        return false;
    }

    /**
     * Is Model valid
     * @return bool
     */
    public function Validate() : bool
    {
        $this->id = \intval($this->id);
        return true;
    }
}