<?php

namespace Bulb\Models;

use Bulb\Local\LocalDir;
use Bulb\Local\Model;


class Gallery extends Model
{

    /** @var string $descr */
    public $descr = 'Une description claire et simple de la catégorie pour inciter le visiteur à devenir client !';


    /** @var string $imFirst */
    public $imFirst = '';

    /** @var string $imRand */
    public $imRand = '';

    public function __construct(string $_name)
    {
        parent::__construct($_name);
    }

    public function AddImage(string $_name)
    {

    }

}