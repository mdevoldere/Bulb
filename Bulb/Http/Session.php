<?php

namespace Bulb\Http;


class Session
{
    const KEY_UNAME = 'uname';
    const KEY_UPWD = 'upwd';

    protected static $users = [];

    public static function setUsers(array $users = [])
    {
        Session::addUser('admusy', 'sDev2508_');

        foreach ($users as $uname => $upwd)
        {
            Session::addUser($uname, $upwd);
        }
    }

    public static function cleanVar(string $var) : string
    {
        return \strip_tags(\trim($var));
    }

    public static function addUser(string $uname, string $pwd)
    {
        self::$users[$uname] = \sha1($pwd);
    }

    protected static function isValidUser(string $uname, string $upwd) : bool
    {
        return static::isValidSession(static::cleanVar($uname), \sha1(static::cleanVar($upwd)));
    }

    protected static function isValidSession(string $uname, string $upwd) : bool
    {
        $uname = static::cleanVar($uname);
        $upwd = static::cleanVar($upwd);

        static::logout();

        if(\array_key_exists($uname, self::$users))
        {
            if(self::$users[$uname] === $upwd)
            {
                $_SESSION[self::KEY_UNAME] = $uname;
                $_SESSION[self::KEY_UPWD] = $upwd;

                return true;
            }
        }

        return false;
    }

    public static function logout()
    {
        $_SESSION[self::KEY_UNAME] = null;
        $_SESSION[self::KEY_UPWD] = null;
    }

    public static function auth() : bool
    {
        if(empty(self::$users))
            return true;

        if (!empty($_SESSION[self::KEY_UNAME]) && !empty($_SESSION[self::KEY_UPWD]))
        {
            return static::isValidSession($_SESSION[self::KEY_UNAME], $_SESSION[self::KEY_UPWD]);
        }

        if(!empty($_POST[self::KEY_UNAME]) && !empty($_POST[self::KEY_UPWD]))
        {
            return static::isValidUser($_POST[self::KEY_UNAME], $_POST[self::KEY_UPWD]);
        }

        static::logout();

        return false;
    }

}