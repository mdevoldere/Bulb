<?php

namespace Bulb;


use Bulb\App\App;
use Bulb\App\Application;
use Composer\Autoload\ClassLoader;

class BulbLoader
{
    /**
     * @var \Composer\Autoload\ClassLoader
     */
    protected static $loader = null;

    public static function register(ClassLoader $_loader)
    {
        static::setLoader($_loader);

        \set_error_handler('\\Bulb\\Local\\Exception\\Exception::err');
        \set_exception_handler('\\Bulb\\Local\\Exception\\Exception::exc');

        if(\defined('BULB_APP') && \defined('BULB_INSTANCE'))
            static::run(BULB_APP, BULB_INSTANCE);
    }

    public static function setLoader(ClassLoader $_loader)
    {
        static::$loader = $_loader;
    }

    public static function run(string $appName, string $appInstance)
    {
        $app = new Application($appName, $appInstance);
        static::$loader->addPsr4($app->Namespace(), $app->Path());
        //exiter($loader);
        //exporter($app, $app->Namespace());
        //exporter($loader);
        //\exiter($app);
        $app->Run();
        //exit(BULB_APP.': No App to display !');
    }
}