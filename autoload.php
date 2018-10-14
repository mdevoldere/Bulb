<?php
/**
 * Bulb Educational PHP Framework
 * V 1.0.0
 * PHP 7+
 * MySQL 5+
 */

/** Bulb Root Directory (this directory) */
define('BULB_ROOT', __DIR__.'/');

/** Bulb Core Directory */
define('BULB', BULB_ROOT.'Bulb/');

/** Bulb CoreMVC Directory */
define('BULB_MVC', BULB.'MVC/');

/** Bulb Default Apps Directory */
define('BULB_APP', BULB_ROOT.'BulbApp/');

/** Bulb Cache Directory */
define('BULB_CACHE', BULB_ROOT.'BulbCache/');

/** Bulb Cache Directory */
define('BULB_CONFIG', BULB_ROOT.'BulbConfig/');

/** Bulb Public Web Directory */
define('BULB_WEB', BULB_ROOT.'Web/');

/** Debug functions (disabled in production) */
require_once BULB.'dev.php';

/**
 * Load Composer autoload file
 */
if(\is_file(BULB_ROOT.'/Vendor/autoload.php'))
{
    require_once BULB_ROOT.'/Vendor/autoload.php';

    if(defined('BULB_APPCURRENT'))
    {
        $app = new \Musy\MVC\App(BULB_APPCURRENT);
        $app->run();
        exit(BULB_APPCURRENT.': No App to display !');
    }
}

/**
 * If no App defined in BULB_APPCURRENT, spit out a generic message
 */
exit('Nothing to display !');
