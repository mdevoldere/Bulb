<?php


namespace Bulb;


class Application
{
    /** @var string $name */
    protected $name;

    /** @var string $instance */
    protected $instance;

    /** @var string $path */
    protected $path;

    /** @var string $url */
    protected $url;



    public function __construct(string $_path, string $_instance, string $_url = '/')
    {
        if(empty($_path))
            \trigger_error('App: Empty App Path[]'.\_exporter($this));

        $this->path = (\rtrim($_path, '/').'/');

        $this->name = \basename($this->path);

        if(!\is_dir($this->path))
            \trigger_error('App: Invalid App Path['.$this->name.']'.\_exporter($this));

        $this->instance = !empty($_instance) ? \basename($_instance) : 'Web';


    }

}