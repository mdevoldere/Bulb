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

class Local extends Collection implements ILocal
{

    /**
     * Get LocalPath Object ref to BULB_CACHE.basename($_path)
     * @param string $_path
     * @return LocalDir
     */
    public static function getLocalCache(string $_path) : LocalDir
    {
        return LocalDir::getLocalDir((BULB_CACHE.\basename($_path)), true);
    }


    /******************************************************
     ******************** LOCAL OBJECT ********************
    *******************************************************/

    /**
     * Path of current directory|file
     * @var string $path
     */
    protected $path;

    /**
     * Is the local directory|file exists
     * @var bool $exists
     */
    protected $exists;


    /** Get Path of current directory|file
     * @return string
     */
    public function getPath() : string
    {
        return $this->path;
    }

    /**
     * Is the local directory|file exists
     * @return bool
     */
    public function isRegistered() : bool
    {
        return $this->exists;
    }

    /**
     * Is the local directory|file exists
     * @return bool
     */
    public function isValid() : bool
    {
        return $this->exists;
    }

    /**
     * Local constructor.
     * @param string $_path directory|file path
     */
    public function __construct(string $_path)
    {
        $this->path = \trim($_path);

        parent::__construct($this->path);

        $this->exists = false;
    }

    /**
     * Delete operation does nothing by default. Can be overriden in child objects
     * @param null|mixed $_filter
     * @return bool
     */
    public function delete($_filter = null): bool
    {
        return false;
    }

    /*public function update($key, $value = null, bool $_force = true): bool
    {
        return false;
    }

    public function updateAll($_collection = [], bool $_force = true): bool
    {
        return false;
    }*/

    /**
     * Save operation does nothing by default. Can be overriden in child objects
     * @param null|mixed $_data
     * @return int
     */
    public function save($_data = null) : int
    {
        return false;
    }

}