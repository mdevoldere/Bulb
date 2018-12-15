<?php

namespace Bulb\Local;


class LocalDir extends LocalFile
{
    public static function isDir(string $_path = null, bool $_create = false) : bool
    {
        if(empty($_path))
            return false;

        if(($_create === true) && (!\is_dir($_path) && (!\is_file($_path))))
        {
            try
            {
                \mkdir($_path);
                \sleep(1);
            }
            catch (\Exception $e)
            {
                \trigger_error('Local::isDir::NoAccess');
            }
        }

        return \is_dir($_path);
    }

    /**
     * Browse items inside $_path
     * @param string $_path
     * @param string $filter
     * @return array
     */
    public static function globDir(string $_path, string $filter = null)
    {
        if(!LocalDir::isDir($_path, false))
            return [];

        $filter = $filter ?: '*';

        $g = [];

        foreach(\glob($_path.'{'.$filter.'}', GLOB_BRACE) as $f)
        {
            $g[$f] = \basename($f);
        }

        return $g;
    }


    /**
     * LocalDir constructor.
     * @param string $_path
     * @param bool $_create
     */
    public function __construct(string $_path, bool $_create = false)
    {
        $this->path = \rtrim(\trim($_path), '/');

        $this->name = \basename($this->path);

        $this->exists = LocalDir::isDir($this->path, $_create);

        $this->path = ($this->path.'/');
    }

    /**
     * @param string|null $_filter
     * @return array
     */
    public function Load($_filter = null)
    {
        return LocalDir::globDir($this->path, $_filter);
    }

    public function File(string $_filename) : LocalFile
    {
        $_filename = ($this->path.\basename($_filename));
        return new LocalFile($_filename);
    }

    public function Dir(string $_dirname, bool $_create = false) : LocalDir
    {
        $_dirname = ($this->path.\basename($_dirname));
        return new LocalDir($_dirname, $_create);
    }

    /**
     * Save operation does nothing in LocalDir Context
     * @param null|mixed $_data
     * @return int
     */
    public function Save($_data = null) : int
    {
        return 0;
    }



}