<?php


namespace Bulb\Http;


class Secure
{
    /**
     * @param null $value
     * @param null $default
     * @return mixed|null|string
     */
    public static function cleanLower($value = null, $default = null)
    {
        if($value === null)
        {
            if($default != null)
                $value = $default;
            else
                return null;
        }

        if(\is_string($value) || \is_int($value))
        {
            return (\trim(\strip_tags($value)));
        }

        return $default;
    }
}