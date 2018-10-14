<?php

namespace Bulb\Tools;


class Utils
{

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
    }

}