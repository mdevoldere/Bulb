<?php


namespace Bulb\Local;


class Secure
{

    public static function Validate($_key = null)
    {
        return ((!empty($_key) && (\is_string($_key) || is_int($_key))) ? $_key : null);
    }

    /**
     * @param mixed $_key
     * @return int|null|string
     */
    public static function Key($_key = null)
    {
        if(\is_string($_key))
        {
            $_key = \trim(\strip_tags($_key));
            $_key = \str_replace("  ", " ", $_key);
            $_key = \str_replace(" ", "-", $_key);
        }

        return static::Validate($_key);
    }

    public static function Name($_name = null)
    {
        if(\is_string($_name))
        {
            $_name = \trim(\strip_tags($_name));
            $_name = \str_replace("  ", " ", $_name);
            $_name = \str_replace("-", " ", $_name);
        }

        return static::Validate($_name);
    }

    /**
     * @param null $_value
     * @param null $_default
     * @return mixed|null|string
     */
    public static function ValueOrDefault($_value = null, $_default = null)
    {
        $_value = $_value ?: $_default;

        if(\is_string($_value))
        {
            $_value = \trim(\strip_tags($_value));
        }

        return static::Validate($_value);
    }
}