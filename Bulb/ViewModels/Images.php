<?php

namespace Bulb\ViewModels;


use Bulb\App\App;
use Bulb\App\Collection;
use Bulb\App\Local;


class Images extends Collection
{
    protected $localPath;

    protected $webPath;


    public function __construct(App $_app, string $_dirname = 'images')
    {
        $_dirname = \basename($_dirname);

        parent::__construct($_app->Cache('img-'.$_dirname.'.php'));

        $this->localPath = ($_app->LocalWebPath($_dirname.'/'));

        $this->webPath = $_app->WebPath($_dirname.'/');

        $this->Load();
    }

    public function Load(?string $_filename = null) : array
    {
        parent::Load();

        if(empty($this->items))
        {
            $this->LoadImages();
        }

        return $this->items;
    }

    public function LoadImages()
    {
        $this->items = [];

        $a = Local::globDir($this->localPath, '*.jpg');

        foreach ($a as $img)
        {
            $this->items[$img] = ($this->webPath.$img);
        }

        if(\count($this->items) > 0)
        {
            $this->Save();
        }
    }
}