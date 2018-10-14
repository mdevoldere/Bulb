<?php

namespace Bulb\MVC;


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


    public function __construct($dir)
    {
        $this->rootPath = ($dir.'Views/');
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
            $loader = new \Twig_Loader_Filesystem([$this->rootPath, BULB_MVC.'Views/'], $this->rootPath);

            $this->env = new \Twig_Environment($loader, array(
                //'cache' => BULB_CACHE,
                'debug' => true,
            ));
        }

        return $this->env;
    }

    public function addPath($dir)
    {
        if(\is_dir($this->rootPath.$dir))
        {
            $this->getLoader()->addPath($this->rootPath.$dir);
        }
    }

    public function prependPath($dir)
    {
        if(\is_dir($this->rootPath.$dir))
        {
            $this->getLoader()->prependPath($this->rootPath.$dir);
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