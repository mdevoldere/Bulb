<?php

namespace Bulb\App;


class Local
{
    /** Recursivly Convert _collection to array
     * @param array|Model $_collection collection to browse
     * @return array
     */
    public static function ArrayExport($_collection) : array
    {
        if($_collection instanceof Model)
            return Local::ArrayExport($_collection->FindAll());

        if(!\is_array($_collection))
            return [];

        $r = [];

        foreach($_collection as $k => $v)
        {
            if($v instanceof Model)
                $v = $v->FindAll();
            elseif (\is_object($v))
                $v = \get_object_vars($v);

            if(\is_array($v))
                $r[$k] = Local::ArrayExport($v);
            else
                $r[$k] = $v;
        }

        return $r;
    }

    /**
     * @param string $_path
     * @return string
     */
    public static function LoadFileContent(string $_path)
    {
        return ((\is_file($_path) && \is_readable($_path)) ? \file_get_contents($_path) : '');
    }

    /**
     * @param string $_path
     * @param bool $_create
     * @return bool
     */
    public static function isDir(string $_path, bool $_create = false) : bool
    {
        if(empty($_path))
            return false;

        if(($_create === true) && (!\is_dir($_path) && (!\is_file($_path))))
        {
            try
            {
                \mkdir($_path);
                \sleep(1);
            }
            catch (\Exception $e)
            {
                \trigger_error('Local::isDir::NoAccess');
            }
        }

        return \is_dir($_path);
    }

    /**
     * Browse items inside $_path
     * @param string $_path
     * @param string $_filter
     * @return array
     */
    public static function globDir(string $_path, string $_filter = null)
    {
        if(!Local::isDir($_path, false))
            return [];

        $_filter = $_filter ?: '*';

        $r = [];

        foreach(\glob($_path.'{'.$_filter.'}', GLOB_BRACE) as $f)
        {
            $r[$f] = \basename($f);
        }

        return $r;
    }
}