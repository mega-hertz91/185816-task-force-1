<?php


namespace Models;


class Roles extends Model
{
    protected $name = 'role';

    public function __construct()
    {
        parent::__construct();
    }

    public function all() {
        return parent::getTable($this->name);
    }

    public function getRole($id) {
        return parent::getID($this->name, $id);
    }

    public function getRoleByUser($user_id) {

    }
}
