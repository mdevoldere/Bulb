<?php

namespace Bulb\MVC;

class Model
{
    /** 
     * @var int
    */
    public $id = 0;

    public function __construct(array $values = [])
    {
        $this->hydrate($values);
    }

    public function hydrate(array $values = [])
    {
        if(!empty($values))
        {
            foreach ($values as $k => $v)
            {
                if(\property_exists($this, $k))
                {
                    $this->{$k} = $v;
                }
            }
        }
    }

    /** @return bool */
    public function isRegistered()
    {
        return ($this->id > 0);
    }

    /** 
     * @return bool 
    */
    public function isValid()
    {
        return true;
    }
}