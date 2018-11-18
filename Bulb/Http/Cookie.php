<?php

namespace Bulb\Http;


class Cookie
{
    const DEFAULT_COOKIE_TIME = 2592000; // 30 days

    public static function setCookie(string $_name, string $_value, $_expire = null)
    {
        return \setcookie($_name, $_value, (time() + (($_expire !== null) ? $_expire : self::DEFAULT_COOKIE_TIME)), "/");
    }

    public static function unsetCookie(string $_name)
    {
        if (isset($_COOKIE[$_name])) {
            unset($_COOKIE[$_name]);
            return \setcookie($_name, null, (time() - 3600), "/");
        }

        return true;
    }

    public static function getCookie(string $_name)
    {
        return (isset($_COOKIE[$_name]) ? $_COOKIE[$_name] : null);
    }
}