<?php

namespace Bulb\Models;


use Bulb\Local\Model;

class Contact extends Model
{

    public $id;

    public $name;

    public $email;

    public $phone;

    public $address;

    public $zipcode;

    public $city;

    public $country;

    public function __construct($_id = null, ?string $_name = null)
    {
        parent::__construct($_id);

        $this->name = $_name;
    }

    public function IsValid() : bool
    {
        return (!empty($this->name)
             && !empty($this->email)
             && \filter_var($this->email, FILTER_VALIDATE_EMAIL));
    }
}