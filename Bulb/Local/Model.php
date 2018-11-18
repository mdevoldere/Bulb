<?php

namespace Bulb\Local;

/**
 * Class Model
 * @package Bulb\Local
 */
class Model implements IModel
{
    /**
     * @var int $id
     */
    protected $id;

    /**
     * @var string $name
     */
    protected $name;


    /**
     * Base Model contains 2 properties: (int)ID and (string)NAME
     * Model constructor.
     * @param int $_id Current Model ID
     * @param string $_name
     */
    public function __construct(int $_id = 0, string $_name = '')
    {
        $this->id = $_id;
        $this->name = \basename($_name);
    }

    /**
     * @return int
     */
    public function getId() : int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * Returns true if isValid() if current Model ID > 0
     * @return bool
     */
    public function isRegistered() : bool
    {
        return ($this->isValid() && ($this->id > 0));
    }

    /**
     * Returns true if current Model $name is setted
     * @return bool
     */
    public function isValid() : bool
    {
        return !empty($this->name);
    }

    /**
     * Returns a property value if found in current Model
     * @param $_key
     * @param null|mixed $_default
     * @return mixed
     */
    public function find($_key, $_default = null)
    {
        return \property_exists($this, $_key) ? $this->{$_key} : $_default;
    }

    /**
     * Returns object as an array
     * @param null|mixed $_filter
     * @return array
     */
    public function findAll($_filter = null) : array
    {
        return \get_object_vars($this);
    }


    /**
     * Update property $_key with $_value
     * @param mixed $_key property to update
     * @param null|mixed $_value  new value
     * @param bool $_force set to false to fake update
     * @return bool
     */
    public function update($_key, $_value = null, bool $_force = true) : bool
    {
        if(!\property_exists($this, $_key))
            return false;

        if(($_force === false))
            return true;

        $this->{$_key} = $_value;

        return true;
    }

    /**
     * Update properties of current Model using $_collection
     * @param array|IModel $_collection where each key is a property name
     * @param bool $_force
     * @return bool
     */
    public function updateAll($_collection = [], bool $_force = true) : bool
    {
        if($_collection instanceof IModel)
            $_collection = $_collection->findAll();

        if(\is_array($_collection))
        {
            foreach ($_collection as $k => $v)
            {
                $this->update($k, $v, $_force);
            }
        }

        return true;
    }

    /**
     * Returns current Model as string. Only strings & numerics are shown.
     * @param null $_filter
     * @return string
     */
    public function toString($_filter = null) : string
    {
        $s = ($this->id.'. '.$this->name."\n");

        foreach ($this->findAll($_filter) as $k => $v)
        {
            if(\is_string($v) || \is_numeric($v))
                $s .= ($k.': '.$v."\n");
        }

        return $s;
    }

}