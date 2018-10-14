<?php

namespace Bulb\MVC;

use Bulb\Tools\Collection;

class App
{
    /** @var string  */
    protected $name;

    /** @var string  */
    protected $dir;

    /** @var  Router */
    protected $router = null;

    /** @var Collection */
    protected $config;

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
        return $this->getRouter()->getRequest();
    }

      /**
     * @return Router
     */
    public function getRouter()
    {
        $this->router = $this->router ?: new Router(true);
        return $this->router;
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
     * Constructor
     */
    public function __construct($_name)
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
                       
            $n = 'BulbApp\\'.$this->name.'\\Controllers\\'.\mb_convert_case($this->getRequest()->getController(), MB_CASE_TITLE).'Controller';
            
            /** @var Controller $c */
            $c = (new $n($this));

            $a = ($this->getRequest()->getAction().'Action');

            if(!\method_exists($c, $a))
            {
                throw new \InvalidArgumentException('Invalid action ['.$this->getRequest()->getAction().'] !');
            }

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