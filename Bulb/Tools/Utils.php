<?php

namespace Bulb\Tools;


class Utils
{

    public static function cleanLower($value = null, $default = null)
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

    public static function getFolder($dir, $filter = '*.*')
    {
        return (\glob($dir.'{'.$filter.'}', GLOB_BRACE));
    }

    public static function getFolderFiles($dir, $filter = '*.*')
    {
        $g = [];

        foreach(static::getFolder($dir, $filter) as $f)
        {
            $g[] = \basename($f);
        }

        return $g;
    }

}