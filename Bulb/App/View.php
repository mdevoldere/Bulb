<?php

namespace Bulb\App;


class View
{
    const VIEW_EXT = '.twig.html';

    public static function getFileName($name)
    {
        return ($name.self::VIEW_EXT);
    }


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
     * @return \Twig_LoaderInterface|\Twig_Loader_Filesystem
     */
    public function getLoader()
    {
        return $this->getEnv()->getLoader();
    }

    /**
     * @return \Twig_Environment
     */
    public function getEnv()
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

    public function addPath($dir, bool $_prepend = true)
    {
        if(\is_dir($this->rootPath.'Views/'.$dir))
        {
            if($_prepend === true)
                $this->getLoader()->prependPath($this->rootPath.'Views/'.$dir);
            else
                $this->getLoader()->addPath($this->rootPath.'Views/'.$dir);
        }
    }

    public function addGlobal($name, $value)
    {
        $this->getEnv()->addGlobal($name, $value);
    }

    public function render($template, array $vars = [])
    {
        return $this->getEnv()->render(static::getFileName($template), $vars);
    }

    public function display($template, array $vars = [])
    {
        echo $this->render($template, $vars);
        exit;
    }
}