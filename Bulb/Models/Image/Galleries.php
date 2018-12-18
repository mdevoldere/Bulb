<?php

namespace Bulb\Models;

use Bulb\App\Application;
use Bulb\Local\Collection;
use Bulb\Local\LocalCollection;

class Galleries extends LocalCollection
{

    protected $webPath;

    /** @var Images $images */
    protected $images;

    /** @var array $items */
    protected $items = [];


    public function __construct(Application $_app)
    {
        $this->images = new Images($_app->Path().'Web/images/');

        parent::__construct($this->images->Dirname().'galleries.php');

        $this->webPath = $_app->Config()->Find('path').'images/im/';

        $this->Load();
    }

    public function AddGallery(string $_gallery) : bool
    {
        $_gallery = \basename($_gallery);

        if(empty($this->items[$_gallery]))
        {
            $this->items[$_gallery] = [
                'cover' => '',
                'pics' => [],
            ];
            return true;
        }
        return false;
    }

    public function AttachImage(string $_gallery, string $_image)
    {
        $im = $this->images->Image($_image);

        if($im !== null)
        {
            if($this->AddGallery($_gallery))
                $this->items[$_gallery]['cover'] = $im;

            $this->items[$_gallery]['pics'][$im] = $im;
        }
    }

    public function DetachImage(string $_gallery, string $_image)
    {
        if(!empty($this->items[$_gallery]['pics'][$_image]))
        {
            unset($this->items[$_gallery]['pics'][$_image]);
        }

        if($this->items[$_gallery]['cover'] === ($this->webPath.$_image))
        {
            $this->items[$_gallery]['cover'] = \reset($this->items[$_gallery]['pics']);
        }

    }

    public function Load()
    {
        $this->images->Load();
        $this->localFile->Load();
    }

    public function LoadImages()
    {
        $this->images->LoadImages();
        $this->localFile->Load();
    }


    public function CountImages() : int
    {
        return $this->images->Count();
    }

}