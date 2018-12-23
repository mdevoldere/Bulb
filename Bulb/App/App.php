<?php

namespace Bulb\App;

use Bulb\Local\LocalCollection;
use Bulb\Local\LocalFile;

class App
{
    /** @var string $name */
    protected $name;

    /** @var string $instance */
    protected $instance;

    /** @var string $path */
    protected $path;

    /** @var string $webPath */
    protected $webPath;

    /** @var string */
    protected $cache;

    /** @var LocalCollection $config */
    protected $config;


    public function __construct(?string $_path, ?string $_instance = 'Web')
    {
        if(empty($_path))
            \trigger_error('App: Empty App Path[]'.\_exporter($this));

        $this->path = \trim($_path);

        $this->name = \basename($this->path);

        if(!\is_dir($this->path))
            \trigger_error('App: Invalid App Path['.$this->name.']'.\_exporter($this));

        $this->instance = !empty($_instance) ? \basename($_instance) : 'Web';

        $this->cache = ($this->path.'Cache/');

        $this->config = $this->CacheCollection('conf');

        $this->config->AddFile($this->Path('conf.php'));

        $this->config->Load();

        $this->webPath = $this->Config()->Find('path');
    }

    public function Name() : string
    {
        return $this->name;
    }

    public function Instance() : string
    {
        return $this->instance;
    }

    public function Path(?string $_suffix = null) : string
    {
        return ($this->path.(!empty($_suffix) ? $_suffix : ''));
    }

    public function WebPath(?string $_suffix = null) : string
    {
        return ($this->webPath.(!empty($_suffix) ? $_suffix : ''));
    }

    public function Cache(?string $_suffix = null) : string
    {
        return ($this->cache.(!empty($_suffix) ? ($this->instance.'-'.$_suffix) : ''));
    }

    public function Config() : LocalCollection
    {
        return $this->config;
    }


    public function Namespace() : string
    {
        return ($this->name.'\\');
    }

    public function InstancePath(?string $_suffix = null) : string
    {
        return ($this->Path($this->instance.'/').(!empty($_suffix) ? $_suffix : ''));
    }

    public function CacheFile(string $_filename) : LocalFile
    {
        return new LocalFile($this->Cache($_filename.'.php'));
    }

    public function CacheCollection(string $_filename) : LocalCollection
    {
        return new LocalCollection($this->Cache($_filename.'.php'));
    }

    public function Controller(string $_controller) : string
    {
        return ($this->name.'\\Controllers\\'.\mb_convert_case(\basename($_controller), MB_CASE_TITLE).'Controller');
    }

}