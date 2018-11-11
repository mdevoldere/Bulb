<?php

namespace Bulb\Http;

use Bulb\MVC\App;

class Router
{
    const DEFAULT_CONTROLLER = 'home';

    const DEFAULT_ACTION = 'index';

    const DEFAULT_ID = null;

    protected $baseUrl = '';

    /** @var string  */
    protected $controller = self::DEFAULT_CONTROLLER;

    /** @var string  */
    protected $action = self::DEFAULT_ACTION;

    /** @var null|int|string  */
    protected $id = self::DEFAULT_ID;

    /** @var string  */
    protected $path = '/';

    /** @var Request */
    protected $request;


    /***** GETTERS *****/

    /**
     * @return string
     */
    public function getController()
    {
        return ($this->controller);
    }

    /**
     * @return string
     */
    public function getAction()
    {
        return ($this->action);
    }

    /**
     * @return null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->baseUrl.$this->path;
    }

    /**
     * @return Request
     */
    public function getRequest(): Request
    {
        return $this->request;
    }


    /**
     * Router constructor.
     * @param string $_baseUrl
     */
    public function __construct(string $_baseUrl = '')
    {
        $this->baseUrl = (\rtrim($_baseUrl, '/'));
        $this->parseUrl();
    }

    /**
     * @param string $get_key
     * @return $this
     */
    public function parseUrl(string $get_key = Request::DEFAULT_GET_KEY)
    {
        try
        {
            $route = Request::parseUrl($get_key);

            if(!empty($route))
            {
                $this->setRoute(
                    (!empty($route[0]) ? $route[0] : null),
                    (!empty($route[1]) ? $route[1] : null),
                    (!empty($route[2]) ? $route[2] : null)
                );
            }
        }
        catch(\Exception $e)
        {
            $this->setRoute();
        }

        return $this;
    }

    /**
     * @param string|null $controller
     * @param string|null $action
     * @param null $id
     * @return $this
     */
    public function setRoute(string $controller = null, string $action = null, $id = null)
    {
        $this->controller   = Secure::cleanLower($controller, static::DEFAULT_CONTROLLER);
        $this->action       = Secure::cleanLower($action, static::DEFAULT_ACTION);
        $this->id           = Secure::cleanLower($id, static::DEFAULT_ID);

        $this->path         = ('/'.$this->controller.'/'.$this->action.(!empty($this->id) ? '/'.$this->id : ''));

        return $this;
    }

    /**
     * @param null $url
     */
    public function go($url = null)
    {
        if(!\headers_sent())
        {
            \header('location: '.((null !== $url) ? $url : $this->getUrl()).'');
            exit();
        }
    }

    /**
     * @param string|null $controller
     * @param string|null $action
     * @param null $id
     */
    public function goTo(string $controller = null, string $action = null, $id = null)
    {
        $this->setRoute($controller, $action, $id)->go();
    }

}