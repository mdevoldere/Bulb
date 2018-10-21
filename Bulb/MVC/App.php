<?php

namespace Bulb\MVC;

use Bulb\Tools\Collection;

/**
 * Class App
 * @package Bulb\MVC
 */
class App
{
    const DEFAULT_NAMESPACE = 'BulbApp';

    /** @var string  */
    protected $name;

    /** @var string  */
    protected $namespace;

    /** @var string  */
    protected $dir;

    /** @var Collection */
    protected $config;

    /** @var  Request */
    protected $request;

    /** @var View */
    protected $view = null;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getNamespace(): string
    {
        return $this->namespace;
    }

    /**
     * @param $key
     * @return array|mixed
     */
    public function getConfig($key = null)
    {
        if(empty($this->config))
        {
            $this->config = new Collection((\is_file($this->dir.'conf.php') ? ($this->dir.'conf.php') : (BULB_MVC.'conf.default.php')));
        }

        return (null !== $key) ? $this->config->get($key) : $this->config;
    }

    /**
     * @return Request
     */
    public function getRequest() : Request
    {
        return $this->request;
    }

    /**
     * @return View
     */
    public function getView() : View
    {
        $this->view = $this->view ?: new View($this->dir);
        return $this->view;
    }

    /**
     * @param $_name
     * @param $_request
     * Constructor
     */
    public function __construct($_name, Request $_request = null)
    {
        $this->name = \basename($_name);

        if(\is_dir(BULB_APP.$this->name))
        {
            $this->namespace = (App::DEFAULT_NAMESPACE.'\\'.$this->name.'\\');
            $this->dir = (BULB_APP.$this->name.'/');
        }
        elseif(\is_dir($_name) && !\is_dir(__DIR__.'/'.$this->name))
        {
            $this->namespace = ('\\'.$this->name.'\\');
            $this->dir = ($_name.'/');
        }
        else
        {
            exit('App: Invalid App['.$this->name.']');
        }

        $this->request = $_request ?: Request::getRequest();
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
            $this->getView()->prependPath($this->getRequest()->getController());

            $this->getView()->addGlobal('request', $this->getRequest());
                       
            $out = Router::runController($this);

            exit($out); // spit out method result
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