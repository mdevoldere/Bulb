<?php

namespace Bulb\Local;

/**
 * Class Model
 * @package Bulb\Local
 */
class Model
{
    /** Check if given $key is a "not empty string"
     * @param null $_key
     * @return bool
     */
    public static function IsValidProperty($_key = null)
    {
        return (!empty($_key) && \is_string($_key));
    }

    public static function IsValidKey($_key = null)
    {
        return (!empty($_key) && (\is_string($_key) || is_int($_key)));
    }

    /** Recursivly Convert _collection to array
     * @param array|Model $_collection collection to browse
     * @return array
     */
    public static function ArrayExport($_collection) : array
    {
        if($_collection instanceof Model)
            $_collection = $_collection->FindAll();

        if(!\is_array($_collection))
            return [];

        $r = [];

        foreach($_collection as $k => $v)
        {
            if($v instanceof Model)
                $v = $v->ToArray();
            elseif (\is_object($v))
                $v = \get_object_vars($v);

            if(\is_array($v))
                $r[$k] = Model::ArrayExport($v);
            else
                $r[$k] = $v;
        }

        return $r;
    }

    /**
     * Model Unique ID
     * @var int|string $id
     */
    public $id;

    /**
     * Base Model
     * @param int|string $_id
     */
    public function __construct($_id = null)
    {
        $this->id = $_id;
    }

    /**
     * Is Model valid
     * @return bool
     */
    public function IsValid() : bool
    {
        return !empty($this->id);
    }

    /** Get all Model keys/values as array. Values are returned "as they are"
     * @return array
     */
    public function FindAll() : array
    {
        return \get_object_vars($this);
    }

    /** Get all Model keys/values as array. Values using "Model class" are converted to array
     * @return array
     */
    public function ToArray() : array
    {
        return Model::ArrayExport($this);
    }

    /** Get current Model as json object
     * @return string
     */
    public function ToJson() : string
    {
        return \json_encode(static::ToArray());
    }
}