<?php

namespace Bulb\Http;


/**
 * Class Request
 * @package Bulb\Http
 */
class Request implements IRequest
{
    const DEFAULT_GET_KEY = 'url';

    protected static $defaultRoute = ['home', 'index', null];

    /**
     * @var string $path
     */
    protected $path = '/';

    /**
     * @var array $route
     */
    protected $route;

    /**
     * Request constructor.
     */
    public function __construct()
    {
        $this->route = self::$defaultRoute;
    }

    public function getController(): string
    {
        return $this->route[0];
    }

    public function getAction(): string
    {
        return $this->route[1];
    }

    public function getId()
    {
        return $this->route[2];
    }

    public function getRoute() : array
    {
        return [
            'controller' => $this->route[0],
            'action' => $this->route[1],
            'id' => $this->route[2],
        ];
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getUrl(): string
    {
        return $this->getPath();
    }


    /**
     * @param string $_controller
     * @return $this
     */
    public function setController(string $_controller)
    {
        $this->route[0] = Secure::cleanLower($_controller, self::$defaultRoute[0]);
        return $this;
    }


    public function setAction(string $_action)
    {
        $this->route[1] = Secure::cleanLower($_action, self::$defaultRoute[1]);
        return $this;
    }

    public function setId($_id = null)
    {
        $this->route[2] = Secure::cleanLower($_id, self::$defaultRoute[2]);

        return $this;
    }

    public function setRoute(array $_route)
    {
        $i = 0;
        $this->route = self::$defaultRoute;

        foreach($_route as $item)
        {
            $this->route[$i] = Secure::cleanLower($item, self::$defaultRoute[$i]);
            ++$i;
        }

        $this->path = ('/'.\rtrim(\implode('/', $this->route), '/'));

        return $this;
    }

    public function setPath(string $_path)
    {
        return $this->setRoute(\explode('/', $_path));
    }

    public function setUrl(string $_controller = null, string $_action = null, string $_id = null)
    {
        return $this->setRoute([$_controller, $_action, $_id]);
    }


    public function go($url = null)
    {
        if(!\headers_sent())
        {
            \header('location: '.((null !== $url) ? $url : $this->getUrl()).'');
            exit();
        }
    }

    public function goTo(string $controller = null, string $action = null, $id = null)
    {
        $this->setUrl($controller, $action, $id)->go();
    }
}