<?php

namespace Bulb\MVC;

use Bulb\Tools\Collection;

/**
 * Class App
 * @package Bulb\MVC
 */
class App
{
    /** @var string  */
    protected $name;

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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param $key
     * @return array|mixed
     */
    public function getConfig($key = null)
    {
        if(empty($this->config))
        {
            //exiter($this->dir.'conf.php');
            $this->config = new Collection((\is_file($this->dir.'conf.php') ? ($this->dir.'conf.php') : (BULB_MVC.'conf.default.php')));
        }

        return (null != $key) ? $this->config->get($key) : $this->config;
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @return View
     */
    public function getView()
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
            $this->dir = BULB_APP.$this->name.'/';
        }
        elseif(\is_dir($_name))
        {
            $this->dir = $_name.'/';
        }
        else
        {
            exit('App::'.$this->name.' not found !');
        }

        $this->request = $_request ?: Request::getRequest();
    }

    public function createLayout()
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
                       
            $c = Router::getController($this);

            //exiter($c, 'App::run');

            exit($c->{$a}()); // spit out method result
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