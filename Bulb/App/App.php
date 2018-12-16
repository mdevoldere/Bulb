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

use Bulb\Local\LocalCollection;

class App
{
    /** @var string $name */
    protected $name;

    /** @var string $instance */
    protected $instance;

    /** @var string $path */
    protected $path;

    /** @var string */
    protected $cache;

    /** @var LocalCollection $config */
    protected $config;


    public function __construct(string $_path, ?string $_instance = null)
    {
        $this->path = \trim($_path);

        $this->name = \basename($this->path);

        $this->instance = !empty($_instance) ? \basename($_instance) : 'default';

        if(empty($_path))
            \trigger_error('App: Empty App Path['.$_path.']'.\_exporter($this));

        if(!\is_dir($this->path))
            \trigger_error('App: Invalid App Path['.$this->name.']'.\_exporter($this));

        $this->cache = ($this->path.'Cache/');

        $this->config = new LocalCollection($this->Cache($this->instance.'.php'));

        $this->config->AddFile($this->Path('conf.php'));

        $this->config->Load();
    }

    public function Name() : string
    {
        return $this->name;
    }

    public function Namespace() : string
    {
        return ($this->name.'\\');
    }

    public function Instance() : string
    {
        return $this->instance;
    }

    public function Path(?string $_suffix = null) : string
    {
        return ($this->path.(!empty($_suffix) ? $_suffix : ''));
    }

    public function Cache(?string $_suffix = null) : string
    {
        return ($this->cache.(!empty($_suffix) ? $_suffix : ''));
    }

    public function Config() : LocalCollection
    {
        return $this->config;
    }

    public function Controller(string $_controller) : string
    {
        return ($this->name.'\\Controllers\\'.\mb_convert_case(\basename($_controller), MB_CASE_TITLE).'Controller');
    }

}