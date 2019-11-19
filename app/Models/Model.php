<?php


namespace Models;

class Model
{
    protected $connect;
    protected $host = 'task-force.academy';
    protected $user = 'admin';
    protected $password = 'admin';
    protected $database = 'taskforce';

    public function __construct()
    {
        $this->connect = mysqli_connect($this->host, $this->user, $this->password, $this->database);

        return $this->connect;
    }

    public function getTable($table)
    {
        $result = mysqli_query($this->connect, "SELECT * FROM " . $table);

        $result = mysqli_fetch_all($result, MYSQLI_ASSOC);

        return $result;
    }

    public function getID($table, $id) {
        $result = mysqli_query($this->connect, "SELECT * FROM " . $table . " WHERE id=" . $id);

        $result = mysqli_fetch_object($result);

        return $result;
    }
}
