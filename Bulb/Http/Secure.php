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
        if(\is_string($value) || \is_int($value))
        {
            if($value === null)
            {
                if($default != null)
                    $value = $default;
                else
                    return null;
            }

            return (\mb_convert_case(\trim(\strip_tags(($value))), MB_CASE_LOWER));
        }

        return $default;
    }
}