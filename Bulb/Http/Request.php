<?php

namespace Bulb\Http;


/**
 * Class Request
 * @package Bulb\Http
 */
class Request extends Route
{
    /**
     * @var  string
     */
    const DEFAULT_GET_KEY = 'url';

    /**
     * @var string $baseUrl
     */
    protected $baseUrl;


    /**
     * Request constructor.
     * @param string $_baseUrl
     * @param array $_route
     */
    public function __construct(string $_baseUrl = '', array $_route = [])
    {
        $this->baseUrl = ((!empty($_baseUrl) ? \rtrim($_baseUrl, '/') : ''));
        parent::__construct($_route);
    }

    public function ParseUrl()
    {
        if(!empty($_GET[self::DEFAULT_GET_KEY]))
            parent::Url($_GET[self::DEFAULT_GET_KEY]);
    }

    public function Url(?string $_url = null) : string
    {
        return ($this->baseUrl.parent::Url($_url));
    }

    public function RedirectTo(?string $_controller = null, ?string $_action = null, ?string $_id = null)
    {
        if(!\headers_sent())
        {
            \header('location: '.($this->baseUrl.parent::Path($_controller, $_action, $_id)));
            exit();
        }
    }


}