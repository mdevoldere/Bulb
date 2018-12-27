<?php

namespace Bulb\Models\Image;

use Bulb\App\App;
use Bulb\App\Secure;
use Bulb\App\LocalCollection;

class Galleries extends LocalCollection
{
    /** @var Images $images */
    protected $images;

    /** @var array $items */
    protected $items = [];


    public function __construct(App $_app)
    {
        $this->images = new Images($_app);

        parent::__construct($_app->Cache('galleries.php'));

        $this->Load();
    }

    public function Load($_filename = null) : array
    {
        $this->images->Load();
        return parent::Load();
    }

    public function LoadImages()
    {
        $this->images->LoadImages();
        parent::Load();
    }


    public function CountImages() : int
    {
        return $this->images->Count();
    }

    public function Has($_key = null): ?string
    {
        $_key = Secure::Key($_key);
        return parent::Has($_key);
    }


    public function AddGallery(string $_gallery, string $_description = '') : bool
    {
        $current = $this->Find($_gallery);

        if($current !== null)
        {

        }

        $_gallery_key = Secure::Key($_gallery);
        $_gallery = Secure::Name($_gallery_key);

        if(!empty($_gallery_key) && empty($this->items[$_gallery_key]))
        {
            $this->items[$_gallery_key] = [
                'name' => $_gallery,
                'cover' => '',
                'description' => $_description,
                'pics' => [],
            ];
            return true;
        }
        return false;
    }

    public function UpdateGallery(string $_gallery, string $_newName, string $_newDescription = '') : bool
    {
        $_gallery_key = Secure::Key($_gallery);
        $_gallery = Secure::Name($_gallery_key);

        if(!empty($_gallery_key) && !empty($_newName_key) && !empty($this->items[$_gallery_key]))
        {
            if($this->AddGallery($_newName, $_newDescription))
            {
                $g = $this->Find($_newName);
            }

            $this->items[$_gallery_key] = [
                'name' => $_gallery,
                'cover' => '',
                'description' => $_newDescription,
                'pics' => [],
            ];
            return true;
        }
        return false;
    }

    public function RemoveGallery(string $_gallery) : bool
    {
        $_gallery = \basename($_gallery);

        if(!empty($this->items[$_gallery]))
        {
            unset($this->items[$_gallery]);
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

            $this->items[$_gallery]['pics'][$im] = ($this->webPath.$im);
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

    public function Save($_data = null): int
    {
        \ksort($this->items);
        return parent::Save($_data);
    }


}