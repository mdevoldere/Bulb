<?php

namespace Bulb\App;


use Bulb\Local\Collection;

class Layout extends Collection
{
    protected $theme = null;

    protected $css = null;

    protected $body = null;


    public function __construct($theme = null)
    {
        $this->Theme($theme ?? 'default');
        $this->init();
    }

    protected function init()  { }


    /**
     * @param mixed $_theme
     * @return string
     */
    public function Theme(?string $_theme = null)
    {
        if($_theme !== null)
            $this->theme = $_theme;

        return $_theme;
    }

    /**
     * @param null|string $_body
     * @return string
     */
    public function Body(?string $_body = null)
    {
        if($_body !== null)
            $this->body = $_body;

        return $this->body;
    }

    /**
     * @param string $_css
     * @return string
     */
    public function Css(?string $_css = null)
    {
        if($_css !== null)
            $this->css = $_css;

        return $this->css;
    }


}