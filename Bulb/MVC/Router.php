<?php

namespace Bulb\MVC;

class Router
{
    protected $query = [];

    /** @var  Request */
    protected $request;

    /**
     * @return Request
     */
    public function getRequest()
    {
        $this->request = $this->request ?: new Request();
        return $this->request;
    }

    public function __construct($_parseUrl = false)
    {
        if($_parseUrl === true)
            $this->parseUrl();
        else
            $this->setRoute();
    }

    public function parseUrl()
    {
        \parse_str($_SERVER['QUERY_STRING'], $this->query);

        if(\array_key_exists('url', $this->query)) 
        {
            $this->setRoute($this->query['url']);
        }

        return $this;
    }

    public function setRoute($route = null)
    {
        try
        {
            if(!\is_array($route))
            {
                $route = \explode('/', $route);
            }

            $this->getRequest()->setRequest(
                (!empty($route[0]) ? $route[0] : null),
                (!empty($route[1]) ? $route[1] : null),
                (!empty($route[2]) ? $route[2] : null)
            );
        }
        catch(\Exception $e)
        {

        }

        return $this;
    }

    public function redirectTo($controller = null, $action = null, $id = null)
    {
        $this->getRequest()->setRequest($controller, $action, $id);
        $this->getRequest()->go();
    }

    public function go($prefix = '')
    {
        $this->getRequest()->go($prefix);
    }
}