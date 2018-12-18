<?php

namespace Bulb\Models;


use Bulb\Local\LocalCollection;
use Bulb\Local\LocalDir;


class Images extends LocalCollection
{

    public function __construct(string $_path)
    {
        parent::__construct($_path.'images.php');
    }

    public function Image(string $_name) : ?string
    {
        $im = $this->Find($_name);

        if($im !== null)
        {
            return ($this->localFile->Dirname().$im);
        }

        return null;
    }

    public function Load()
    {
        parent::Load(); // TODO: Change the autogenerated stub

        if(empty($this->items))
        {
            $this->LoadImages();
        }
    }

    public function LoadImages()
    {
        $a = LocalDir::globDir($this->localFile->Dirname(), '*.jpg');

        foreach ($a as $img)
        {
            $this->items[$img] = $img;
        }

        if($this->Count() > 0)
        {
            $this->localFile->Save($this);
            $this->imFirst = \reset($this->items);
            $this->imRand = $this->items[\rand(0, ($this->Count() -1))];
        }
    }

}