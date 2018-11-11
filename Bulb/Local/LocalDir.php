<?php


namespace Bulb\Local;


class LocalDir extends Local
{

    /**
     * LocalFile Objects Storage
     * @var LocalFile[]
     */
    public static $f = [];


    public static function getLocalFile(string $_path) : LocalFile
    {
        if(!\array_key_exists($_path, static::$f))
        {
            static::$f[$_path] = new LocalFile($_path);
        }

        return static::$f[$_path];
    }


    public static function isDir(string $_path = null, bool $_create = false) : bool
    {
        if(empty($_path))
            exit('Local::EmptyDir');

        if(($_create === true) && (!\file_exists($_path)) && (!\is_dir($_path)))
        {
            try
            {
                \mkdir($_path);
                \sleep(1);
            }
            catch (\Exception $e)
            {
                exit('Local::isDir::NoAccess');
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
        if(!\is_dir($_path))
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
        parent::__construct($_path);

        $this->path = \rtrim($this->path, '/');

        $this->exists = static::isDir($this->path, $_create);

        $this->path = ($this->path.'/');
    }

    /**
     * @param null $filter
     * @return array
     */
    public function glob($filter = null)
    {
        if(!$this->exists)
            return [];

        return static::globDir($this->path, $filter);
    }

    /**
     * @param string $_filename
     * @return LocalFile
     */
    public function getFile(string $_filename) : LocalFile
    {
        $_filename = ($this->path.\basename($_filename));

        return static::getLocalFile($_filename);
    }

    /**
     * @param string $_filename
     * @return bool
     */
    public function deleteFile(string $_filename) : bool
    {
        return $this->getFile($_filename)->delete();
    }
}