<?php


namespace App\Services;


class SeedUserStatus extends ParserCSV
{
    protected $keys = ['status'];
    protected $table = 'user_status';

    public function getSQL()
    {
        $results = [];

        // TODO: Implement getSQL() method.

        foreach ($this->toQuotes() as $arr) {
            $values = $this->toString($arr);
            $keys = $this->toString($this->keys);
            $query = "INSERT INTO $this->table($keys) VALUES($values);";

            array_push($results ,$query);
        }

        $this->save($results);
    }
}
