<?php

namespace Bulb\App;

use Bulb\Http\IRequest;
use Bulb\Http\Request;
use Bulb\Http\Router;
use Bulb\Local\LocalDir;
use Bulb\Local\LocalFile;

/**
 * Class App
 * @package Bulb\MVC
 */
class Application
{
    const DEFAULT_NAMESPACE = 'BulbApp';

    /** @var App */
    protected $app;

    /** @var IRequest */
    protected $request;

    /**
     * @return App
     */
    public function getApp(): App
    {
        return $this->app;
    }

    /**
     * @return IRequest
     */
    public function getRequest() : IRequest
    {
        return ($this->request = $this->request ?: new Router($this->getConfig()->find('path', '/')));
    }

    /** @var View */
    protected $view = null;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->app->getName();
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->app->getPath();
    }

    /**
     * @return string
     */
    public function getNamespace(): string
    {
        return $this->app->getNamespace();
    }

    /**
     * @return LocalDir
     */
    public function getCache(): LocalDir
    {
        return $this->app->getCache();
    }

    /**
     * @return LocalFile
     */
    public function getConfig() : LocalFile
    {
        return $this->app->getConfig();
    }


    /**
     * @return View
     */
    public function getView() : View
    {
        $this->view = $this->view ?: new View($this->app->getPath());
        return $this->view;
    }

    /**
     * @param App $_application
     * @param IRequest $_request
     * Constructor
     */
    public function __construct(App $_application, IRequest $_request = null)
    {
        $this->app = $_application;

        if($_request !== null)
            $this->request = $_request;

        $this->getRequest();
    }

    public function createLayout() : Layout
    {
        $l = new Layout($this->getConfig()->find('theme'));

        $l->setCss($this->getConfig()->find('css'));

        return $l;
    }

    public function run()
    {
        try
        {
            $this->getView()->prependPath($this->getRequest()->getController());

            $this->getView()->addGlobal('request', $this->request->getRoute());

            $c = $this->app->getControllerNamespace($this->getRequest()->getController());

            $c = (new $c($this));

            $a = ($this->getRequest()->getAction().'Action');

            if(!\method_exists($c, $a))
            {
                throw new \InvalidArgumentException('BulbApp::InvalidAction['.$this->getRequest()->getAction().']');
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
        return ($this->app->getConfig()->find('url').$path);
    }

}