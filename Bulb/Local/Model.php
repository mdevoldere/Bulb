<?php

namespace Bulb\Local;

/**
 * Class Model
 * @package Bulb\Local
 * @see \Bulb\Local\IModel
 */
class Model implements IModel
{
    /**
     * Build search filter
     * @param int|string|array $_pattern
     * @param null|mixed $_filter
     * @return array
     */
    public static function buildFilter($_pattern, $_filter = null) : array
    {
        try
        {
            if(empty($_pattern))
                return [];

            if($_pattern instanceof IModel)
            {
                $_pattern = $_pattern->findAll();
            }
            elseif(\is_string($_pattern))
            {
                if(\substr($_pattern, 0, 1) === '{')
                    $_pattern = @\json_decode($_pattern, true);
                else
                    $_pattern = [$_pattern => $_filter];
            }

            if(!\is_array($_pattern))
                $_pattern = [];

            return $_pattern;
        }
        catch (\Exception $e)
        {
            return [];
        }
    }


    /**
     * @var string|int $id
     */
    protected $id;

    /**
     * Base Model contains 1 property: ID
     * Model constructor.
     * @param int|string $_id
     */
    public function __construct($_id = null)
    {
        $this->setId($_id);
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($_id = null)
    {
        $this->id = !empty($_id) ? $_id : null;
        return $this;
    }

    public function isValid() : bool
    {
        return !empty($this->id);
    }

    public function getFilter($_key, $_value = null) : array
    {
        try
        {
            $r = [];

            foreach (static::buildFilter($_key, $_value) as $k => $v)
            {
                if(\property_exists($this, $k))
                    $r[$k] = $v;
                elseif (\property_exists($this, $v))
                    $r[$v] = null;
            }

            return $r;
        }
        catch (\Exception $e)
        {
            return [];
        }
    }

    public function has($_key, $_value = null) : bool
    {
        if(\is_string($_key) && \property_exists($this, $_key))
        {
            return (($_value === null) ? true : ($this->{$_key} === $_value));
        }
        elseif(\is_array($_key))
        {
            foreach ($_key as $k => $v)
            {
                if(!$this->has($k, $v))
                {
                    if(!$this->has($v, null))
                        return false;
                }
            }

            return true;
        }

        return false;
    }

    public function hasNull($_key) : bool
    {
        return $this->has($_key) ? ($this->{$_key} === null) : false;
    }

    public function find($_pattern, $_filter = null)
    {
        if($this->has($_pattern, $_filter))
            return $this->{$_pattern};

        return null;
    }

    public function findAll($_filter = null) : array
    {
        if(empty($_filter))
            return \get_object_vars($this);

        $r = [];

        foreach (static::buildFilter($_filter) as  $k => $v)
        {
            if($this->has($v))
                $r[] = $this->{$v};
            elseif($this->hasValue($k, $v))
                $r[] = $this->{$k};
        }

        return $r;
    }



    public function insert($_key, $_value = null): bool
    {
        foreach (static::buildFilter($_key, $_value) as $k => $v)
        {
            if($this->hasNull($k))
                $this->{$k} = $v;
        }

        return true;
    }

    public function update($_pattern, $_filter = null) : bool
    {
        foreach (static::buildFilter($_pattern, $_filter) as $k => $v)
        {
            if($this->has($k))
                $this->{$k} = $v;
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
        $s = (\basename(\get_called_class()).'::'.$this->id."\n");

        foreach ($this->findAll($_filter) as $k => $v)
        {
            if(\is_string($v) || \is_numeric($v))
                $s .= ($k.': '.$v."\n");
        }

        return $s;
    }

}