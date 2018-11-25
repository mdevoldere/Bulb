<?php

namespace Bulb\Http;


class Router extends Request
{
    protected $baseUrl = '';

    /**
     * Router constructor.
     * @param string $_baseUrl
     * @param string $_get_key
     */
    public function __construct(string $_baseUrl = '', string $_get_key = 'url')
    {
        parent::__construct();
        $this->baseUrl = (\rtrim($_baseUrl, '/'));

        if(!empty($_GET[$_get_key]))
            $this->setPath($_GET[$_get_key]);
    }

    /**
     * @return string
     */
    public function getUrl() : string
    {
        return $this->baseUrl.$this->getPath();
    }



}