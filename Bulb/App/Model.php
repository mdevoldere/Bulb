<?php

namespace Bulb\App;

/**
 * Class Model
 * @package Bulb\Local
 */
class Model implements IModel
{
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

    public function FindAll() : array
    {
        return \get_object_vars($this);
    }

    public function ToArray() : array
    {
        return Local::ArrayExport($this->FindAll());
    }

}