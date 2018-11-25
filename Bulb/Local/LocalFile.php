<?php

namespace Bulb\Local;

class LocalFile extends Collection implements ILocal
{

    /**
     * Path of current |file
     * @var string $path
     */
    protected $path;

    /**
     * Is the local file exists
     * @var bool $exists
     */
    protected $exists;

    /**
     * LocalFile constructor.
     * @param string $_path
     * @param bool $_loadAsCollection
     */
    public function __construct(string $_path, bool $_loadAsCollection = false)
    {
        $this->path = \trim($_path);

        if(!LocalDir::isDir(\dirname($this->path), false))
            \trigger_error('LocalFile::InvalidFileDir');

        $this->exists = \is_file($this->path);

        if($_loadAsCollection)
            $this->findAll();
    }

    /**
     * Is the local directory|file exists
     * @return bool
     */
    public function isValid() : bool
    {
        return $this->exists;
    }

    /** Get Path of current directory|file
     * @return string
     */
    public function getPath() : string
    {
        return $this->path;
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

        return $this->items;
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

    public function toString($_filter = null) : string
    {
        if($this->isValid())
            return (\file_get_contents($this->path));

        return '';
    }

}