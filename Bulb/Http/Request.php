<?php

namespace Bulb\Http;

use Bulb\Local\Collection;
use Bulb\Tools\Utils;


class Request
{
    const DEFAULT_GET_KEY = 'url';

    protected static $query = [];


    /**
     * Get Item from $_GET or $_GET array if no key specified
     * returns null if no result
     * @param null|mixed $key
     * @param mixed $default
     * @return mixed|null
     */
    public static function get($key = null, $default = null)
    {
        if($key === null)
            return !empty($_GET) ? $_GET : [];

        return \array_key_exists($key, $_GET) ? $_GET[$key] : $default;
    }

    /**
     * Get Item from $_POST or $_POST array if no key specified
     * returns null if no result
     * @param null|mixed $key
     * @param mixed $default
     * @return mixed|null
     */
    public static function post($key = null, $default = null)
    {
        if($key === null)
            return !empty($_POST) ? $_POST : [];

        return \array_key_exists($key, $_POST) ? $_POST[$key] : $default;
    }

    /**
     * Get Item from $_FILES or $_FILES array if no key specified
     * returns null if no result
     * @param null $key
     * @return mixed|null
     */
    public static function files($key = null)
    {
        if($key === null)
            return !empty($_FILES) ? $_FILES : [];

        return \array_key_exists($key, $_FILES) ? $_FILES[$key] : null;
    }

    /**
     * Get Item from $_SESSION or $_SESSION array if no key specified
     * returns null if no result
     * @param null|mixed $key
     * @param null $value
     * @return mixed
     */
    public static function session($key = null, $value = null)
    {
        if($key === null)
            return !empty($_SESSION) ? $_SESSION : [];

        if($value !== null)
        {
            $_SESSION[$key] = $value;
        }

        return \array_key_exists($key, $_SESSION) ? $_SESSION[$key] : null;
    }

    public static function parseUrl(string $key = '') : array
    {
        if(empty($key))
            $key = self::DEFAULT_GET_KEY;

        // \parse_str($_SERVER['QUERY_STRING'], self::$query);

        return \array_key_exists($key, $_GET) ? \explode('/', $_GET[$key]) : [];
    }

    public static function getRequest()
    {
        return [
            'session' => self::session(),
            'get' => self::get(),
            'post' => self::post(),
            'files' => self::files(),
        ];
    }

    /** Request constructor. */
    protected function __construct() { }

}