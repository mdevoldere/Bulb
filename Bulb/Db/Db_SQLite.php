<?php

namespace Bulb\Db;


class Db_SQLite extends Db
{

    public function __construct($filepath)
    {
        parent::__construct(DbManager::PDO_Sqlite($filepath));
    }

    public function fetch($table, $column, $value, $single = true)
    {
        $q = $this->pdo->prepare("SELECT * FROM ".\basename($table)." WHERE ".\basename($column)."=:val;");

        $q->bindValue(':val', $value, static::getPdoType($value));

        $q->execute();

        $r = (($single === true) ? $q->fetch() : $q->fetchAll());

        $q->closeCursor();

        return $r;
    }

    public function insert($table, array $values)
    {
        $qStr = ('INSERT INTO "'.$table.'" ("');

        $cols = \array_keys($values);

        $qStr .= (\implode('", "', $cols).'"');

        $qStr.= "\nVALUES (:";

        $qStr .= \implode(", :", $cols).");";

        exiter($qStr);

        $q = $this->pdo->prepare($qStr);

        static::execute($q, $values);

        $q->closeCursor();

        return 1;
    }

    public function update($table, array $values, $where_col = null, $where_value = null)
    {
        $qStr = ('UPDATE "'.$table.'" SET '."\n");

        $cols = [];

        foreach ($values as $k => $v)
        {
            $cols[] = ('"'.$k.'"=:'.$k.'');
        }

        $qStr .= \implode(', ', $cols).' ';

        if(($where_col !== null) && ($where_value !== null))
        {
            $qStr .= ("\n".' WHERE "'.$where_col.'"=:cond_'.$where_col.'');
        }

        $q = $this->pdo->prepare($qStr.';');

        static::bindValue($q, $where_col, $where_value);

        static::execute($q, $values);

        $q->closeCursor();

        return 1;
    }
}