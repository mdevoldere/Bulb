<?php

namespace Bulb\App;

if(!\defined('BULB_CACHE'))
{
    \define('BULB_CACHE', \dirname(__DIR__, 2).'/BulbCache/');

    if(!\is_dir(BULB_CACHE))
    {
        \mkdir(BULB_CACHE);
    }
}

use Bulb\Local\LocalDir;
use Bulb\Local\LocalFile;

class App extends LocalDir
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

    /** @var string $instance */
    protected $instance;

    /** @var LocalDir */
    protected $cache;

    /** @var LocalFile $config */
    protected $config;

    public function __construct(string $_path, string $_instance)
    {
        parent::__construct($_path, false);

        if(!$this->exists)
            \trigger_error('App: Invalid App['.$this->name.']'.\_exporter($this));

        $this->cache = $this->find('Cache');

        if(!$this->cache->isValid())
            $this->cache = static::getLocalCache($this->name);

        $this->instance = \basename($_instance);

        $this->config = $this->cache->find($this->instance.'.php', true);

        $this->config->updateAll($this->find('conf.php', true), false);
    }

    /**
     * @return LocalDir
     */
    public function getCache(): LocalDir
    {
        return $this->cache;
    }

    /**
     * @return LocalFile
     */
    public function getConfig() : LocalFile
    {
        return $this->config;
    }


    /**
     * @return string
     */
    public function getNamespace() : string
    {
        return ($this->name.'\\');
    }

    /**
     * @return string
     */
    public function getInstance() : string
    {
        return $this->instance;
    }

    public function getControllerNamespace($_controller)
    {
        return ($this->getNamespace().'Controllers\\'.\mb_convert_case(\basename($_controller), MB_CASE_TITLE).'Controller');
    }

}