<?php

namespace Bulb\App;

/**
 * Class LocalDir
 * @package Bulb\App
 * @deprecated
 */
class LocalDir extends LocalFile
{
    /**
     * @param string|null $_path
     * @param bool $_create
     * @return bool
     * @deprecated
     */
    public static function isDir(string $_path = null, bool $_create = false) : bool
    {
        return Local::isDir($_path, $_create);
    }

    /**
     * Browse items inside $_path
     * @param string $_path
     * @param string $_filter
     * @return array
     * @deprecated
     */
    public static function globDir(string $_path, string $_filter = null)
    {
        return Local::globDir($_path, $_filter);
    }


    /**
     * LocalDir constructor.
     * @param string $_path
     * @param bool $_create
     * @deprecated
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