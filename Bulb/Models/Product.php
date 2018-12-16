<?php

namespace Bulb\Models;


use Bulb\Local\Model;

class Product extends Model
{

    public $id;

    public $name = 'Product';

    public $price = 0;

    public $description = 'Product Description';

    public $details = 'Product Details';

    public $attributes = [];


    public function __construct($_id = 'Product', ?string $_name = 'Product Name')
    {
        parent::__construct($_id);

        $this->name = $_name;
    }

}