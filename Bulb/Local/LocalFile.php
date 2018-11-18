<?php

namespace Bulb\Local;

class LocalFile extends Local
{

    /** @var null|Collection $collection */
    protected $collection = null;

    /**
     * LocalFile constructor.
     * @param string $_path
     * @param bool $_loadAsCollection
     */
    public function __construct(string $_path, bool $_loadAsCollection = false)
    {
        parent::__construct($_path);

        if(!LocalDir::isDir(\dirname($_path), false))
            exit('LocalFile::InvalidFileDir');

        $this->path = $_path;

        $this->exists = \is_file($this->path);

        if($_loadAsCollection)
            $this->findAll();
    }

    public function findAll($_includeMaster = null) : array
    {
        if(empty($this->items) && $this->isValid())
        {
            try
            {
                $a = (require $this->path);
               // exporter($a, 'aaa');
                $this->items = \is_array($a) ? $a : [];
               // exporter($this, $this->name);
            }
            catch (\Exception $e)
            {
                \trigger_error($e->getMessage(), E_USER_ERROR);
            }
        }

        return parent::findAll($_includeMaster);
    }

    public function toString($_filter = null) : string
    {
        if($this->isValid())
            return (\file_get_contents($this->path));

        return '';
    }


    /**
     * @param null|mixed $_data
     * @return int
     */
    public function save($_data = null) : int
    {
        try
        {
            if(empty($_data))
                $_data = !empty($this->items) ? $this->items : '';

            if($_data instanceof IModel)
                $_data = $_data->findAll();

            if(\is_array($_data))
                $_data = ('<?php return '.\var_export($_data, true).';');

            if(!\is_string($_data) || empty($_data))
                return 0;

            $r = \file_put_contents($this->path, $_data);

            $this->exists = true;

            return (($r !== false) ? $r : 0);
        }
        catch (\Exception $e)
        {
            return 0;
        }
    }

    /**
     * @param null|mixed $_filter
     * @return bool
     */
    public function delete($_filter = null) : bool
    {
        if($this->isValid())
            $this->exists = !(\unlink($this->path));

        return !$this->exists;
    }

}