<?php

namespace Bulb\Db;


class Db
{
    public static function getPdoType($var)
    {
        $t = \gettype($var);

        if($t === 'string') 	return \PDO::PARAM_STR;
        if($t === 'integer') 	return \PDO::PARAM_INT;
        if($t === 'boolean') 	return \PDO::PARAM_BOOL;
        if($t === 'NULL') 		return \PDO::PARAM_NULL;

        return \PDO::PARAM_STR;
    }

    public static function bindValue(\PDOStatement $stmt, $k = null, $v = null)
    {
        if(!empty($k) && !empty($v))
        {
            $stmt->bindValue((':'.$k), $v, static::getPdoType($v));
        }
    }

    public static function bindValues(\PDOStatement $stmt, array $values)
    {
        foreach ($values as $k => $v)
        {
            $stmt->bindValue((':'.$k), $v, static::getPdoType($v));
        }
    }

    public static function execute(\PDOStatement $stmt, array $values = [])
    {
        if(!empty($values))
        {
            static::bindValues($stmt, $values);
        }

        return $stmt->execute();
    }

    /** @var \PDO  */
    protected $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getTable($name)
    {
        return new Table($name, $this);
    }

    public function fetchAll($table)
    {
        $q = $this->pdo->query("SELECT * FROM ".\basename($table).";");

        return $q->fetchAll();
    }

    public function fetch($table, $column, $value, $single = true)
    {
        return false;
    }

    public function insert($table, array $values)
    {
        return 0;
    }

    public function update($table, array $values, $where_col = null, $where_value = null)
    {
        return 0;
    }

    public function delete($table, $column, $value)
    {
        return 0;
    }
}