<?php
/**
 * Bulb Educational PHP Framework
 * V 1.0.0
 * PHP 7+
 * MySQL 5+
 */

/** Bulb Root Directory (parent directory) */
define('BULB_ROOT', (dirname(__DIR__).'/'));

/** Bulb Core Directory */
define('BULB', (__DIR__.'/'));

/** Bulb CoreMVC Directory */
define('BULB_VIEWS', BULB.'Views/');

/** Bulb Cache Directory */
define('BULB_CACHE', BULB_ROOT.'BulbCache/');


\session_start();


/** Debug functions (disabled in production) */
require_once BULB.'dev.php';

//exiter((get_defined_constants(true)));

/**
 * Load Composer autoload file
 */
if(\is_file(BULB_ROOT.'/Vendor/autoload.php'))
{
    /** @var \Composer\Autoload\ClassLoader $loader */
    $loader = require_once BULB_ROOT.'/Vendor/autoload.php';

    set_error_handler('\\Bulb\\Local\\Exception\\Exception::err');
    set_exception_handler('\\Bulb\\Local\\Exception\\Exception::exc');

    if(defined('BULB_APP') && defined('BULB_INSTANCE'))
    {
        $app = new \Bulb\App\App(BULB_APP, BULB_INSTANCE);
        $loader->addPsr4($app->getNamespace(), $app->getPath());
        //exiter($loader);
        //exiter($app, $app->getNamespace());
        //exporter($loader);
        $application = new \Bulb\App\Application($app);
        $application->run();
        //exit(BULB_APP.': No App to display !');
    }
}

/**
 * If no App defined in BULB_APP, spit out a generic message
 * define BULB_STANDALONE constant to disable exit command.
 */
if(!defined('BULB_STANDALONE'))
{
    trigger_error('Bulb: Nothing to display !', E_USER_NOTICE);
}