<?php


namespace App\Services;

class SeedUser extends ParserCSV
{
    protected $keys = ['email', 'full_name', 'password', 'created_at', 'role_id', 'city_id', 'user_status_id'];
    protected $table = 'user';

    public function getSQL()
    {

        $results = [];

        // TODO: Implement getSQL() method.

        foreach ($this->toQuotes() as $arr) {
            $values = $this->toString($arr);
            $keys = $this->toString($this->keys);
            $query = "INSERT INTO $this->table($keys) VALUES($values, 1, 1, 1);";

            array_push($results ,$query);
        }

      $this->save($results);

    }
}
