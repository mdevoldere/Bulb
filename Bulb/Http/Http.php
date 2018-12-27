<?php


namespace Bulb\Http;


use Bulb\App\Secure;

class Http
{
    /**
     * Get Item from $_GET or $_GET array if no key specified
     * returns null if no result
     * @param null|mixed $key
     * @param mixed $default
     * @return mixed|null
     */
    public static function Get($key = null, $default = null)
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
    public static function Post($key = null, $default = null)
    {
        if($key === null)
            return !empty($_POST) ? $_POST : [];

        return \array_key_exists($key, $_POST) ? ($_POST[$key]) : $default;
    }

    /**
     * Get Item from $_FILES or $_FILES array if no key specified
     * returns null if no result
     * @param null $key
     * @return mixed|null
     */
    public static function Files($key = null)
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
    public static function Session($key = null, $value = null)
    {
        if($key === null)
            return !empty($_SESSION) ? $_SESSION : [];

        if($value !== null)
        {
            $_SESSION[$key] = $value;
        }

        return \array_key_exists($key, $_SESSION) ? $_SESSION[$key] : null;
    }

    public static function UnsetSession(string $key)
    {
        if(\array_key_exists($key, $_SESSION))
            unset($_SESSION[$key]);
    }


    public static function ParseUrl(string $key = '') : array
    {
        if(empty($key))
            $key = 'url';

        // \parse_str($_SERVER['QUERY_STRING'], self::$query);

        return \array_key_exists($key, $_GET) ? \explode('/', $_GET[$key]) : [];
    }

    public static function Request()
    {
        return [
            'session' => self::Session(),
            'get' => self::Get(),
            'post' => self::Post(),
            'files' => self::Files(),
        ];
    }
}