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
                $v = $v->ToArray();
            elseif (\is_object($v))
                $v = \get_object_vars($v);

            if(\is_array($v))
                $r[$k] = Local::ArrayExport($v);
            else
                $r[$k] = $v;
        }

        return $r;
    }

    public static function LoadFile(string $_path, Collection $_collection = null) : array
    {
        if(\is_file($_path) && \is_readable($_path))
        {
            try
            {
                $a = (require $_path);
                // exporter($a, 'aaa');
                $a = \is_array($a) ? $a : [];

                if($_collection !== null)
                {
                    $_collection->Update($a);
                }

                return $a;

            }
            catch (\Exception $e)
            {
                \trigger_error($e->getMessage(), E_USER_ERROR);

            }
        }

        return [];
    }

    /**
     * @param null $_key
     * @return int|null|string
     */
    public static function ValidateString($_key = null)
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

        return static::ValidateString($_key);
    }

    public static function Name($_name = null)
    {
        if(\is_string($_name))
        {
            $_name = \mb_convert_case(\trim(\strip_tags($_name)), MB_CASE_LOWER);
            $_name = \str_replace("  ", " ", $_name);
        }

        return ((static::ValidateString($_name) !== null) ? \mb_convert_case($_name, MB_CASE_TITLE) : null);
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

        return static::ValidateString($_value);
    }


}