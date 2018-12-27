<?php

namespace Bulb\App;


class Validate
{
    /**
     * @param mixed $_str
     * @return int|null|string
     */
    public static function Value($_str = null)
    {
        return ((!empty($_str) && (\is_string($_str) || is_int($_str))) ? $_str : null);
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

        return Validate::Value($_key);
    }

    /**
     * @param mixed $_name
     * @return mixed|null|string
     */
    public static function Name($_name = null)
    {
        if(\is_string($_name))
        {
            $_name = \mb_convert_case(\trim(\strip_tags($_name)), MB_CASE_LOWER);
            $_name = \str_replace("  ", " ", $_name);
        }

        return ((Validate::Value($_name) !== null) ? \mb_convert_case($_name, MB_CASE_TITLE) : null);
    }
}