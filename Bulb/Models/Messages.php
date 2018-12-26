<?php

namespace Bulb\Models;


use Bulb\App\App;
use Bulb\App\LocalCollection;

class Messages extends LocalCollection
{

    public function __construct(App $_app)
    {
        parent::__construct($_app->Cache('messages.php'));
        $this->Load();
    }

    public function UpdateMessage($_item): bool
    {
        //\exiter($this);
        if(!\is_array($_item) || empty($_item))
            return false;

        if(empty($_item['messageAuthor']) || empty($_item['messageEmail']) || empty($_item['messageContent']))
            return false;

        if(empty($_item['id']))
        {
            $_item['id'] = (!empty($this->items) ? (\max(\array_keys($this->items))+1) : 1);
            $_item['date'] = \date('d-m-y H:i');
            $_item['read'] = '0';
            $_item['response'] = '0';
        }

        $this->Update($_item['id'], $_item);

        return ($this->Save() > 0);
    }

    public function Save($_data = null): int
    {
        \krsort($this->items);
        return parent::Save($_data);
    }


}