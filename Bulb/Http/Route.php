<?php

namespace Bulb\Http;


class Route
{
    protected static $defaultRoute = ['home', 'index', null];

    public static function QueryString(string $_getKey = 'url') : string
    {
        return (!empty($_GET[$_getKey]) ? \trim($_GET[$_getKey]) : '');
    }

    public static function QueryArray(string $_getKey = 'url') : array
    {
        $_getKey = self::QueryString($_getKey);

        return (!empty($_getKey) ? \explode('/', $_getKey) : []);
    }

    /**
     * @var string $queryString
     */
    protected $queryString;

    /**
     * @var string $baseUrl
     */
    protected $baseUrl;

    /**
     * @var string $path
     */
    protected $path;

    /**
     * @var string $url
     */
    protected $url;

    /**
     * @var array $routeIndex
     */
    protected $routeIndex;

    /**
     * @var array $route
     */
    protected $route;


    public function __construct(string $_baseUrl = '', ?string $_key = null)
    {
        $this->queryString = $_SERVER['QUERY_STRING'];

        $this->baseUrl = (((!empty($_baseUrl) ? \rtrim($_baseUrl, '/') : '')).'/');

        $r = self::QueryArray($_key ?: 'url');

        $this->Route($r ?: self::$defaultRoute);
    }

    protected function _RouteItem(int $_pos, ?string $_item = null) : ?string
    {
        if (!empty($_item))
            $this->routeIndex[$_pos] = (\trim(\strip_tags($_item)));

        return \array_key_exists($_pos, $this->routeIndex) ? $this->routeIndex[$_pos] : null;
    }

    public function Route(array $_route = []) : array
    {
        if(!empty($_route))
        {
            $this->routeIndex = static::$defaultRoute;

            $pos = 0;

            foreach($_route as $item)
            {
                $this->_RouteItem($pos++, $item);
            }

            $this->path = (\rtrim(\implode('/', $this->routeIndex), '/'));
            $this->url = ($this->baseUrl.$this->path);
            $this->path = ('/'.$this->path);
        }

        $this->route = [
            'controller' => $this->routeIndex[0],
            'action' => $this->routeIndex[1],
            'id' => $this->routeIndex[2],
        ];

        return $this->route;
    }

    public function Path(?string $_controller = null, ?string $_action = null, ?string $_id = null) : string
    {
        if(!empty($_controller))
            $this->Route([$_controller, $_action, $_id]);

        return $this->path;
    }

    public function Url() : string
    {
        return $this->url;
    }

    public function RedirectTo(?string $_controller = null, ?string $_action = null, ?string $_id = null)
    {
        if(!\headers_sent())
        {
            $this->Path($_controller, $_action, $_id);
            \header('location: '.$this->url);
            exit();
        }
    }


    public function Controller(?string $_controller = null): ?string
    {
        return $this->_RouteItem(0, $_controller);
    }

    public function Action(?string $_action = null): ?string
    {
        return $this->_RouteItem(1, $_action);
    }

    public function Id(?string $_id = null) : ?string
    {
        return $this->_RouteItem(2, $_id);
    }



}