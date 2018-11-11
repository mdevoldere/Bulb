<?php

namespace Bulb\Local;

if(!\defined('BULB_CACHE'))
{
    \define('BULB_CACHE', \dirname(__DIR__, 2).'/BulbCache/');

    if(!\is_dir(BULB_CACHE))
    {
        \mkdir(BULB_CACHE);
    }
}

abstract class Local
{
    /**
     * LocalDir Objects Storage
     * @var LocalDir[]
     */
    protected static $d = [];

    /**
     * Get LocalPath Object ref to $_path
     * @param string|null $_path
     * @param bool $_create
     * @return LocalDir if $_path exists
     */
    public static function getLocalDir(string $_path = null, bool $_create = false) : LocalDir
    {
        if(empty($_path))
            exit('LocalDir::EmptyDir');

        if(empty(static::$d[$_path]))
        {
            static::$d[$_path] = new LocalDir($_path, $_create);
        }

        return static::$d[$_path];
    }

    /**
     * Get LocalPath Object ref to BULB_CACHE.basename($_path)
     * @param string $_path
     * @return LocalDir
     */
    public static function getLocalCache(string $_path) : LocalDir
    {
        return static::getLocalDir((BULB_CACHE.\basename($_path)), true);
    }


    /******************************************************
     ******************** LOCAL OBJECT ********************
    *******************************************************/

    /** @var string $name  */
    protected $name;

    /** @var string $path  */
    protected $path;

    /** @var bool $exists */
    protected $exists;

    /**
     * @return string
     */
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getPath() : string
    {
        return $this->path;
    }

    /**
     * @return bool
     */
    public function isExists()
    {
        return $this->exists;
    }

    /**
     * Local constructor.
     * @param string $_path
     */
    public function __construct(string $_path)
    {
        $this->path = \trim($_path);

        $this->name = \basename($this->path);

        $this->exists = false;
    }

}