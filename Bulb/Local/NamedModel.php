<?php

namespace Bulb\Local;


class NamedModel extends Model
{

    protected $name;

    public function __construct($_id = null, ?string $_name)
    {
        parent::__construct($_id);
        $this->Name($_name);
    }

     /**
     * @param string $_name
     * @return string
     */
    public function Name(?string $_name)
    {
        if(!empty($_name))
            $this->name = \trim($_name);

        return $this->name;
    }

    public function IsValid() : bool
    {
        return !empty($this->name) && parent::IsValid();
    }

}