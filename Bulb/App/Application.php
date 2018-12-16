<?php

namespace Bulb\App;

use Bulb\Http\Request;
use Bulb\Http\Route;

/**
 * Class App
 * @package Bulb\MVC
 */
class Application extends App
{
    const DEFAULT_NAMESPACE = 'BulbApp';

    /** @var Route */
    protected $route = null;

    /** @var View */
    protected $view = null;

    /**
     * @param string $_path
     * @param string $_instance
     * Constructor
     */
    public function __construct(string $_path, ?string $_instance = null)
    {
        parent::__construct($_path, $_instance);

        $this->Route();
    }

    /**
     * @return Route
     */
    public function Route() : Route
    {
        if($this->route === null)
        {
            $this->route = new Route($this->Config()->Find('path', '/'), 'url');
        }

        return $this->route;
    }

    /**
     * @return View
     */
    public function View() : View
    {
        $this->view = $this->view ?: new View($this->Path());
        return $this->view;
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
            exit();
        }
        catch(\Exception $ex)
        {
            \exporter($ex, 'Exception');
            \exiter($this, 'App');
        }

        exit('No App to Run');
    }

    public function Link($path)
    {
        return ($this->Config()->Find('url').$path);
    }

}