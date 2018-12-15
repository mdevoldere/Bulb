<?php

namespace Bulb\Http;


class Route
{
    protected static $defaultRoute = ['home', 'index', null];

    /**
     * @var string $path
     */
    protected $path = '/';

    /**
     * @var array $route
     */
    protected $route;


    public function __construct(array $_route = [])
    {
        $this->route = static::$defaultRoute;
        $this->Route($_route);
    }

    protected function _RouteItem(int $_pos, ?string $_item = null) : ?string
    {
        if ($_item !== null)
            $this->route[$_pos] = (\trim(\strip_tags($_item)));

        return \array_key_exists($_pos, $this->route) ? $this->route[$_pos] : null;
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

    public function Route(array $_route = []) : array
    {
        if(!empty($_route))
        {
            $pos = 0;
            $this->route = self::$defaultRoute;

            foreach($_route as $item)
            {
                $this->_RouteItem($pos, $item);
                ++$pos;
            }

            $this->path = ('/'.\rtrim(\implode('/', $this->route), '/'));
        }

        return [
            'controller' => $this->route[0],
            'action' => $this->route[1],
            'id' => $this->route[2],
        ];
    }

    public function Path(?string $_controller = null, ?string $_action = null, ?string $_id = null) : string
    {
        $this->Route([$_controller, $_action, $_id]);

        return $this->path;
    }

    public function Url(?string $_url = null) : string
    {
        if(!empty($_url))
            $this->Route(\explode('/', $_url));

        return $this->path;
    }

}