<?php


namespace Bulb\ViewModels;


use Bulb\App\App;
use Bulb\App\Model;
use Bulb\App\ModelCollection;
use Bulb\Http\Http;

class Categories extends ModelCollection
{
    public function __construct(App $_app)
    {
        parent::__construct($_app, 'categories');
        $this->Load();
    }

    public function GetModel(array $_values = [])
    {
        return new Category($_values);
    }

    public function UpdateModel(Model $_model, $_save = true) : ?Model
    {
        return (($_model instanceof Category) ? parent::UpdateModel($_model, $_save) : null);
    }

    public function FindBy(string $_key, $_value = null): array
    {
        $item = parent::FindBy($_key, $_value);

        if(!empty($item))
        {
            $item['childs'] = $this->FindChilds($item['id']);
            return $item;
        }

        return [];
    }

    public function FindAllWithParents()
    {
        $r = [];

        foreach ($this->FindAll() as $k => $v)
        {
            if(($v['parent'] < 1))
                $v['childs'] = $this->FindChilds($v['id']);

            $r[$k] = $v;
        }

        return $r;
    }

    public function FindChilds(int $_parent = 0)
    {
        if(empty($_parent))
            return [];

        $r = [];

        foreach ($this->items as $k => $v)
        {
            if(\array_key_exists('parent', $v))
            {
                if(($v['parent'] === $_parent))
                    $r[$k] = $this->items[$k];
            }
        }

        return $r;
    }

    public function Remove($_key = null, $_save = true): bool
    {
        if(!empty($item = $this->Find($_key)))
        {
            if($item['parent'] == 0 && !empty($this->FindChilds($item['id'])))
            {
                Http::Session('danger', 'Impossible de supprimer une catégorie qui contient des sous-catégories. Ré-affectez ou supprimez les sous-catégories en 1er.');
                return false;
            }
        }

        return parent::Remove($_key, $_save);
    }

}