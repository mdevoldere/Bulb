<?php

namespace Bulb\Local;


class LocalDir extends Collection implements ILocal
{

    /**
     * LocalDir Objects Storage
     * @var LocalDir[]
     */
    protected static $d = [];

    /**
     * LocalFile Objects Storage
     * @var LocalFile[]
     */
    public static $f = [];

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

    public static function getLocalFile(string $_path, bool $_loadAsCollection = false) : LocalFile
    {
        if(!\array_key_exists($_path, static::$f))
        {
            static::$f[$_path] = new LocalFile($_path, $_loadAsCollection);
        }

        return static::$f[$_path];
    }


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
        if(!static::isDir($_path, false))
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
     * Path of current directory
     * @var string $path
     */
    protected $path;

    /**
     * Is the local directory exists
     * @var bool $exists
     */
    protected $exists;

    /**
     * LocalDir constructor.
     * @param string $_path
     * @param bool $_create
     */
    public function __construct(string $_path, bool $_create = false)
    {
        $this->name = \basename($_path);

        $this->path = \rtrim($_path, '/');

        $this->exists = static::isDir($this->path, $_create);

        $this->path = ($this->path.'/');
    }

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
     * @param string $_filename
     * @param null|bool|mixed $_loadAsCollection
     * @return LocalDir|LocalFile
     */
    public function find($_filename, $_loadAsCollection = null)
    {
        $_filename = ($this->path.\basename($_filename));

        if(\is_dir($_filename))
        {
            return static::getLocalDir($_filename, false);
        }

        $_loadAsCollection = (($_loadAsCollection !== null) && ($_loadAsCollection !== false));

        return static::getLocalFile($_filename, $_loadAsCollection);
    }

    /**
     * @param null $_filter
     * @return array
     */
    public function findAll($_filter = null) : array
    {
        if(!$this->exists)
            return [];

        return static::globDir($this->path, $_filter);
    }

    /**
     * Save operation does nothing by default. Can be overriden in child objects
     * @param null|mixed $_data
     * @return int
     */
    public function save($_data = null) : int
    {
        return 0;
    }



}