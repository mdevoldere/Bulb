<?php
/**
 * Created by Devoldere.net.
 * User: Mickael DEVOLDERE <support@devoldere.net>
 */

namespace Bulb\Db;


class DbManager
{

    /** @var \PDO[] */
    protected static $_db = [];

    /**
     * @param string $dsn
     * @param string $user
     * @param string $pass
     * @param int $fetchmode
     * @param int $errmode
     * @return \PDO
     */
    public static function PDO_Mysql($dsn, $user, $pass, $fetchmode = \PDO::FETCH_ASSOC, $errmode = \PDO::ERRMODE_EXCEPTION)
    {
        try {
            $db = new \PDO (
                $dsn, $user, $pass,
                array(
                    \PDO::ATTR_ERRMODE => $errmode,
                    \PDO::ATTR_DEFAULT_FETCH_MODE => $fetchmode,
                    \PDO::ATTR_EMULATE_PREPARES => false,
                    // \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
                )
            );

            return $db;
        }
        catch (\PDOException $e) {
            \trigger_error('PDO_Mysql Error (Connection failed)'._exporter($dsn, $user));
        }
    }

    /**
     * @param string $file_path
     * @param string $charset
     * @param int $fetchmode
     * @param int $errmode
     * @return \PDO
     */
    public static function PDO_Sqlite($file_path, $charset = 'UTF-8', $fetchmode = \PDO::FETCH_ASSOC, $errmode = \PDO::ERRMODE_EXCEPTION)
    {
        if(!empty(static::$_db[$file_path]))
        {
            return static::$_db[$file_path];
        }

        try
        {
            //exporter($file_path);
            $db = new \PDO('sqlite:'.$file_path.'', "charset=".$charset);
            $db->setAttribute(\PDO::ATTR_ERRMODE, $errmode);
            $db->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, $fetchmode);
            $db->exec('pragma synchronous = off;');
            static::$_db[$file_path] = $db;
            return static::$_db[$file_path];
        }
        catch(\PDOException $ex) {
            \trigger_error('PDO_Sqlite Error (Connection failed) '.$ex->getMessage()._exporter($file_path));
        }
    }


}