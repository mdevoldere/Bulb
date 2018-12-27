<?php

namespace Bulb\App;


class ViewModel extends Model
{
    public $id;

    public $key = null;

    public $name = null;


    public function Validate() : bool
    {
        $this->name = Validate::Name($this->name);

        if(empty($this->name))
            return false;

        $this->key = \mb_convert_case(Validate::Key($this->name), MB_CASE_LOWER);

        return parent::Validate();
    }

}