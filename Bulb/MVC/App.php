<?php

namespace Bulb\MVC;

use Bulb\App\Application;
use Bulb\Http\Request;
use Bulb\Http\Router;
use Bulb\Local\Collection;
use Bulb\Local\LocalDir;

/**
 * Class App
 * @package Bulb\MVC
 */
class App
{
    const DEFAULT_NAMESPACE = 'BulbApp';

    /** @var Application */
    protected $application;

    /** @var Router */
    protected $router;

    /**
     * @return Router
     */
    public function getRouter() : Router
    {
        return ($this->router = $this->router ?: new Router($this->getConfig('url')));
    }

    /** @var View */
    protected $view = null;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->application->getName();
    }

    /**
     * @return string
     */
    public function getNamespace(): string
    {
        return $this->application->getNamespace();
    }

    /**
     * @return LocalDir
     */
    public function getCache(): LocalDir
    {
        return $this->application->getCache();
    }

    /**
     * @param $key
     * @param $default
     * @return Collection|mixed
     */
    public function getConfig($key = null, $default = null)
    {
        return $this->application->getConfig($key, $default);
    }

    /**
     * @return View
     */
    public function getView() : View
    {
        $this->view = $this->view ?: new View($this->application->getPath());
        return $this->view;
    }

    /**
     * @param Application $_application
     * @param Router $_router
     * Constructor
     */
    public function __construct(Application $_application, Router $_router = null)
    {
        $this->application = $_application;

        if($_router !== null)
            $this->router = $_router;
    }

    public function createLayout() : Layout
    {
        $l = new Layout($this->getConfig('theme'));

        $l->setCss($this->getConfig('css'));

        return $l;
    }

    public function run()
    {
        try
        {
            $this->getView()->prependPath($this->getRouter()->getController());

            $this->getView()->addGlobal('request', Request::getRequest());

            $c = $this->application->getControllerNamespace($this->getRouter()->getController());

            $c = (new $c($this));

            $a = ($this->getRouter()->getAction().'Action');

            if(!\method_exists($c, $a))
            {
                throw new \InvalidArgumentException('BulbApp::InvalidAction['.$this->getRouter()->getAction().']');
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

    public function getLink($path)
    {
        return ($this->getConfig('url').$path);
    }

}