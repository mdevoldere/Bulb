<?php

namespace Bulb\App;


use Bulb\Local\Collection;
use Bulb\Local\Local;
use Bulb\Local\LocalDir;
use Bulb\Local\LocalFile;

class Application extends LocalDir
{

    /** @var LocalDir */
    protected $cache;

    /** @var string $instance */
    protected $instance;

    /** @var LocalFile $config */
    protected $config;

    public function __construct(string $_path, string $_instance)
    {
        parent::__construct($_path, false);

        if(!$this->exists)
            exit('App: Invalid App['.$this->name.']');

        $this->cache = Local::getLocalCache($this->name);

        $this->instance = \basename($_instance);
    }

    /**
     * @return LocalDir
     */
    public function getCache(): LocalDir
    {
        return $this->cache;
    }

    /**
     * @param $key
     * @param $default
     * @return Collection|mixed
     */
    public function getConfig($key = null, $default = null)
    {
        if(empty($this->config))
        {
            $this->config = $this->cache->getFile($this->instance.'.php');
            $this->config->getCollection()->setMasterCollection($this->getFile('conf.php')->getCollection());
        }

        return (null !== $key) ? $this->config->getCollection()->find($key, $default) : $this->config->getCollection();
    }

    /**
     * @return int
     */
    public function saveConfig() : int
    {
        return $this->config->saveCollection(false);
    }

    /**
     * @return string
     */
    public function getNamespace(): string
    {
        return ($this->name.'\\');
    }

    /**
     * @return string
     */
    public function getInstance(): string
    {
        return $this->instance;
    }

    public function getControllerNamespace($_controller)
    {
        return ($this->getNamespace().'Controllers\\'.\mb_convert_case(\basename($_controller), MB_CASE_TITLE).'Controller');
    }

}