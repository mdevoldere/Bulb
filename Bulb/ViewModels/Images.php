<?php

namespace Bulb\ViewModels;


use Bulb\App\App;
use Bulb\App\Local;
use Bulb\App\Model;
use Bulb\App\ModelCollection;
use Bulb\App\Validate;
use Bulb\Http\Http;


class Images extends ModelCollection
{
    protected $localPath;

    protected $webPath;


    public function __construct(App $_app, string $_dirname = 'images')
    {
        parent::__construct($_app, ('im_'.$_dirname));

        $this->localPath = ($_app->LocalWebPath($_dirname.'/'));

        $this->webPath = $_app->WebPath($_dirname.'/');

        $this->Load();
    }

    public function GetModel(array $_values = [])
    {
        return new Image($_values);
    }

    public function UpdateModel(Model $_model, $_save = true) : ?Model
    {
        if($_model instanceof Image)
        {
            if(empty($_model->path))
            {
                $_model->name = \rtrim($_model->name, '.jpg');
                $_model->path = ($this->webPath.$_model->name.'.jpg');
                return parent::UpdateModel($_model, $_save);
            }
        }

        return null;
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
        $a = Local::globDir($this->localPath, '*.jpg');

        $im = ['name' => ''];

        foreach ($a as $img)
        {
            $im['name'] = $img;
            $this->UpdateItem($im, false);
        }

        if(\count($this->items) > 0)
        {
            $this->Save();
        }
    }


    public function Upload(string $_key = 'src') : bool
    {
        if((null !== ($img = Http::Files($_key))))
        {
            if(!\is_uploaded_file($img['tmp_name']))
                return false;

            $info = \getimagesize($img['tmp_name']);

            if($info === false)
                return false;

            if($info['mime'] !== 'image/jpeg')
                return false;

            $img['name'] = Http::Post('name') ?: $img['name'];
            $newImg = $this->UpdateItem($img, false);

            if($newImg instanceof Image)
            {
                if(\move_uploaded_file($img['tmp_name'], ($this->localPath.$newImg->name.'.jpg')))
                {
                    return $this->Save() > 0;
                }
            }
        }

        return false;
    }
}