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
define('BULB_MVC', BULB.'MVC/');

/** Bulb Cache Directory */
define('BULB_CACHE', BULB_ROOT.'BulbCache/');


/** Debug functions (disabled in production) */
require_once BULB.'dev.php';

/**
 * Load Composer autoload file
 */
if(\is_file(BULB_ROOT.'/Vendor/autoload.php'))
{
    /** @var \Composer\Autoload\ClassLoader $loader */
    $loader = require_once BULB_ROOT.'/Vendor/autoload.php';

    if(defined('BULB_APP') && defined('BULB_INSTANCE'))
    {
        $application = new \Bulb\App\Application(BULB_APP, BULB_INSTANCE);
        $loader->addPsr4($application->getNamespace(), $application->getPath());
        $app = new \Bulb\MVC\App($application);
        $app->run();
        exit(BULB_APP.': No App to display !');
    }
}

/**
 * If no App defined in BULB_APP, spit out a generic message
 * define BULB_STANDALONE constant to disable exit command.
 */
if(!defined('BULB_STANDALONE'))
    exit('Bulb: Nothing to display !');