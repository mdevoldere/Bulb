<?php
/**
 * Bulb Educational PHP Framework
 * V 1.0.0
 * PHP 7+
 * MySQL 5+
 * SQLite 3+
 */

/** Bulb Root Directory (parent directory) */
define('BULB_ROOT', (dirname(__DIR__).'/'));

/** Bulb Core Directory (this directory) */
define('BULB', (__DIR__.'/'));

/** Bulb CoreMVC Directory */
define('BULB_VIEWS', BULB.'Views/');

/** Bulb Cache Directory */
define('BULB_CACHE', BULB_ROOT.'BulbCache/');


\session_start();


/** Debug functions (disabled in production package) */
require_once BULB.'dev.php';

//exiter((get_defined_constants(true)));

/**
 * Load Composer autoload file
 */
if(\is_file(BULB_ROOT.'/Vendor/autoload.php'))
{
    /** @var \Composer\Autoload\ClassLoader $loader */
    $loader = require_once BULB_ROOT.'/Vendor/autoload.php';

    \Bulb\BulbLoader::register($loader);
}