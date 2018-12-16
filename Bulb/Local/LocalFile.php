<?php

namespace Bulb\Local;

class LocalFile
{
    /**
     * Name of current |file
     * @var string $name
     */
    protected $name;

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
     */
    public function __construct(string $_path)
    {
        $this->path = \trim($_path);

        $this->name = \basename($this->path);

        $this->exists = \is_file($this->path);
    }

    public function Name() : string
    {
        return $this->name;
    }

    public function Path() : string
    {
        return $this->path;
    }

    public function Exists() : bool
    {
        return $this->exists;
    }

    /**
     * @return string
     */
    public function Load()
    {
        if($this->exists)
            return (\file_get_contents($this->path));

        return '';
    }

    /**
     * @param null|mixed $_data
     * @return int
     */
    public function Save($_data = null) : int
    {
        try
        {
            if($_data instanceof Collection)
            {
                $_data = $_data->ToArray();
            }

            if(\is_array($_data))
            {
                $r = [];

                foreach($_data as $k => $v)
                {
                    if($v instanceof ICollection || $v instanceof IModel)
                        $r[$k] = $v->findAll();
                    else
                        $r[$k] = $v;
                }

                $_data = ('<?php return '.\var_export($r, true).';');
            }

            if(\is_string($_data) && !empty($_data))
            {
                $r = \file_put_contents($this->path, $_data);

                if($r !== false)
                {
                    $this->exists = true;
                    return $r;
                }
            }

            return 0;
        }
        catch (\Exception $e)
        {
            return 0;
        }
    }

}