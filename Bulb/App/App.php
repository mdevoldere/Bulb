<?php

namespace Bulb\App;

use Bulb\Http\Http;
use Bulb\Http\Route;

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

    /** @var Route */
    protected $route = null;

    /** @var LocalCollection $config */
    protected $config;

    /** @var View */
    protected $view = null;

    public function __construct(string $_path, string $_instance = 'Web')
    {
        if(empty($_path))
            \trigger_error('App: Empty App Path[]'.\_exporter($this));

        $this->path = (\rtrim($_path, '/').'/');

        $this->name = \basename($this->path);

        if(!\is_dir($this->path))
            \trigger_error('App: Invalid App Path['.$this->name.']'.\_exporter($this));

        $this->instance = !empty($_instance) ? \basename($_instance) : 'Web';

        $this->config = new Collection($this->Cache('conf.php'));
        $this->config->Load($this->path.'conf.php');
        //\exiter($this);
        $this->config->Load();

        $this->webPath = $this->config->Find('path');

        $this->Route();


    }

    public function Run()
    {
        try
        {
            $this->View()->AddPath($this->Route()->Controller());

            $this->View()->AddGlobal('request', $this->route);

            $c = $this->Controller($this->route->Controller());

            $c = (new $c($this));

            $a = ($this->route->Action().'Action');

            if(!\method_exists($c, $a))
            {
                throw new \InvalidArgumentException('BulbApp::InvalidAction['.$this->route->Action().']');
            }

            echo $c->{$a}();
            Http::UnsetSession('success');
            exit();
        }
        catch(\Exception $ex)
        {
            \exporter($ex, 'Exception');
            \exiter($this, 'App');
        }

        exit('No App to Run');
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

    public function Cache(?string $_filename = null) : string
    {
        $_filename = \basename($_filename);

        return ($this->path.'Cache/'.(!empty($_filename) ? ($this->instance.'-'.$_filename) : ''));
    }

    public function Config() : Collection
    {
        return $this->config;
    }

    public function Namespace() : string
    {
        return ($this->name.'\\');
    }

    /**
     * @return Route
     */
    public function Route() : Route
    {
        if($this->route === null)
        {
            $this->route = new Route($this->config->Find('path'), 'url');
        }

        return $this->route;
    }

    /**
     * @return View
     */
    public function View() : View
    {
        $this->view = $this->view ?: new View($this->path);
        return $this->view;
    }

    public function LocalWebPath(?string $_suffix = null) : string
    {
        return ($this->Path($this->instance.'/').(!empty($_suffix) ? $_suffix : ''));
    }

    public function Controller(string $_controller) : string
    {
        return ($this->name.'\\Controllers\\'.\mb_convert_case(\basename($_controller), MB_CASE_TITLE).'Controller');
    }

    public function DbLocal(string $_filename, array $_struct = []) : ModelCollection
    {
        return new ModelCollection($this, $_filename, $_struct);
    }
}