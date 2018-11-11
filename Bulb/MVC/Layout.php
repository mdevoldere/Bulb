<?php

namespace Bulb\MVC;


use Bulb\Local\Collection;

class Layout extends Collection
{
    protected $theme = null;

    protected $css = null;

    protected $body = null;


    public function __construct($theme = null)
    {
        $this->setTheme($theme);
        $this->init();
    }

    protected function init()  { }

    /**
     * @return mixed
     */
    public function getTheme()
    {
        return $this->theme;
    }

    /**
     * @param mixed $theme
     */
    public function setTheme($theme = null)
    {
        $this->theme = $theme;
    }

    /**
     * @return null|string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param null|string $body
     */
    public function setBody($body = null)
    {
        $this->body = $body;
    }

    /**
     * @return null
     */
    public function getCss()
    {
        return $this->css;
    }

    /**
     * @param null $css
     */
    public function setCss($css)
    {
        $this->css = $css;
    }


}