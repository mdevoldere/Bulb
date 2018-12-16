<?php

namespace Bulb\App;


class View
{
    const VIEW_EXT = '.twig.html';

    public static function getFileName($name)
    {
        return ($name.self::VIEW_EXT);
    }

    protected $layout = 'layout';

    protected $body = null;

    protected $rootPath;

    /** @var \Twig_Environment  */
    protected $env = null;


    /**
     * View constructor.
     * @param $_dir
     */
    public function __construct(string $_dir)
    {
        $this->rootPath = (\rtrim($_dir, '/').'/');
    }

    /**
     * @param mixed $_layout
     * @return string
     */
    public function Layout(?string $_layout = null)
    {
        if($_layout !== null)
            $this->layout = \trim($_layout);

        return $this->layout;
    }

    /**
     * @param null|string $_body
     * @return string
     */
    public function Body(?string $_body = null)
    {
        if($_body !== null)
            $this->body = \trim($_body);

        return $this->body;
    }


    /**
     * @return \Twig_LoaderInterface|\Twig_Loader_Filesystem
     */
    public function Loader()
    {
        return $this->Env()->getLoader();
    }

    /**
     * @return \Twig_Environment
     */
    public function Env()
    {
        if(null === $this->env)
        {
            $loader = new \Twig_Loader_Filesystem([$this->rootPath.'Views/', BULB.'Views/'], $this->rootPath);

            $this->env = new \Twig_Environment($loader, array(
                'cache' => $this->rootPath.'Cache/Twig/',
                'debug' => true,
            ));
        }

        return $this->env;
    }

    public function AddPath($dir, bool $_prepend = true)
    {
        if(\is_dir($this->rootPath.'Views/'.$dir))
        {
            if($_prepend === true)
                $this->Loader()->prependPath($this->rootPath.'Views/'.$dir);
            else
                $this->Loader()->addPath($this->rootPath.'Views/'.$dir);
        }
    }

    public function AddGlobal($name, $value)
    {
        $this->Env()->addGlobal($name, $value);
    }

    public function Render(array $vars = [])
    {
        if($this->body !== null)
            $vars['body'] = $this->body;


        return $this->Env()->render(static::getFileName($this->layout), $vars);
    }

    public function Display(array $vars = [])
    {
        echo $this->Render($vars);
        exit;
    }
}