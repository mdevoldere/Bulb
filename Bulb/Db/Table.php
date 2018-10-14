<?php


namespace Bulb\Db;


class Table
{

    protected $name;

    protected $db;

    //protected $items = [];

    public function __construct($name, Db $db)
    {
        $this->name = $name;
        $this->db = $db;
    }

    public function fetchAll()
    {
        return $this->db->fetchAll($this->name);
    }

    public function fetch($column, $value, $single = true)
    {
        return $this->db->fetch($this->name, $column, $value, $single);
    }

    public function insert(array $values)
    {
        return $this->db->insert($this->name, $values);
    }
}