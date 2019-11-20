<?php

namespace App\Models;

class Users extends Model
{
    protected $name = 'user';

    public function __construct()
    {
        parent::__construct();
    }

    public function all() {
        return parent::getTable($this->name);
    }

    public function getUser($id) {
        return parent::getID($this->name, $id);
    }
}
