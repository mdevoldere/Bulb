<?php

namespace Bulb\App;


use Bulb\Local\Collection;
use Bulb\Local\Local;
use Bulb\Local\LocalDir;
use Bulb\Local\LocalFile;

class App extends LocalDir
{
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
            exit('App: Invalid App['.$this->name.']');

        $this->cache = Local::getLocalCache($this->name);

        $this->instance = \basename($_instance);

        $this->config = $this->cache->find($this->instance.'.php', true);

        $this->config->setMasterCollection($this->find('conf.php', true));
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
     * @return LocalFile
     */
    public function getConfig($key = null, $default = null) : LocalFile
    {
        return $this->config;
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