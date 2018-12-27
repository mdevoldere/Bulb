<?php

namespace Bulb\App;

/**
 * Class Collection
 * @package Bulb\App
 */
class Collection
{
    public static function LoadFile(string $_path, Collection $_collection = null) : array
    {
        if(\is_file($_path) && \is_readable($_path))
        {
            try
            {
                $a = (require $_path);
                // exporter($a, 'a');
                $a = \is_array($a) ? $a : [];

                if($_collection !== null)
                    $_collection->Update($a);

                return $a;
            }
            catch (\Exception $e)
            {
                \trigger_error($e->getMessage(), E_USER_ERROR);
            }
        }

        return [];
    }

    public static function SaveFile(string $_path, array $_collection) : int
    {
        try
        {
            if(!empty($_path) && !empty($_collection))
            {
                $r = \file_put_contents($_path, ('<?php return '.\var_export($_collection, true).';'));

                return (($r !== false) ? $r : 0);
            }
        }
        catch (\Exception $e)
        {
            \trigger_error($e->getMessage(), E_USER_ERROR);
        }

        return 0;
    }


    protected $path;

    /** @var array $items */
    protected $items;

    public function __construct(?string $_path = null)
    {
        $this->path = $_path;
        $this->items = [];
    }

    public function Load(?string $_filename = null) : array
    {
        if(!empty($_filename))
            $_filename = $this->path;

        return !empty($_filename) ? Collection::LoadFile($_filename, $this) : [];
    }

    public function Save() : int
    {
        return ((!empty($this->items) && !empty($this->path)) ? Collection::SaveFile($this->path, $this->items) : 0);
    }

    /**
     * @return int
     */
    public function Count() : int
    {
        return \count($this->items);
    }

    /**
     * @param null $_key
     * @return null|string
     */
    public function Has($_key = null) : ?string
    {
        $_key = Validate::Key($_key);
        return ((($_key !== null) && \array_key_exists($_key, $this->items)) ? $_key : null);
    }

    /**
     * @param int|string $_key
     * @return mixed|null
     */
    public function Find($_key)
    {
        $_key = $this->Has($_key);
        return (($_key !== null) ? $this->items[$_key] : null);
    }

    /**
     * @return array
     */
    public function FindAll() : array
    {
        return $this->items;
    }

    /**
     * @param null $_key
     * @return bool
     */
    public function Remove($_key = null): bool
    {
        if((null !== ($_key = $this->Has($_key))))
        {
            unset($this->items[$_key]);
            return true;
        }

        return false;
    }

    /**
     * @param $_item
     * @param mixed $_value
     * @return bool
     */
    public function Update($_item, $_value = null) : bool
    {
        if((null !== ($_item = Validate::Key($_item))))
        {
            $this->items[$_item] = $_value;
            return true;
        }

        return false;
    }

    /**
     * @param $_item
     * @return bool
     */
    public function UpdateAll($_item)
    {
        if($_item instanceof Collection)
            $_item = $_item->FindAll();

        if(\is_array($_item))
        {
            foreach ($_item as $k => $v)
            {
                $this->Update($k, $v);
            }

            return true;
        }

        return false;
    }

}