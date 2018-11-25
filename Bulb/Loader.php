<?php

namespace Bulb;


use Bulb\App\App;
use Bulb\App\Application;
use Composer\Autoload\ClassLoader;

class Loader
{
    /**
     * @var \Composer\Autoload\ClassLoader
     */
    protected static $loader = null;

    public static function setLoader(ClassLoader $_loader)
    {
        static::$loader = $_loader;
    }

    public static function run(string $appName, string $appInstance)
    {
        $app = new App($appName, $appInstance);
        static::$loader->addPsr4($app->getNamespace(), $app->getPath());
        //exiter($loader);
        //exiter($app, $app->getNamespace());
        //exporter($loader);
        $application = new Application($app);
        $application->run();
        //exit(BULB_APP.': No App to display !');
    }
}