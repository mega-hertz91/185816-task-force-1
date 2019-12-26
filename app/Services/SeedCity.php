<?php


namespace App\Services;


class SeedCity extends ParserCSV
{
    protected $keys = ['name'];
    protected $table = 'city';

    public function getSQL()
    {
        // TODO: Implement getSQL() method.

        $results = [];

        // TODO: Implement getSQL() method.

        foreach ($this->toQuotes() as $arr) {
            $values = array_shift($arr);
            $keys = $this->toString($this->keys);
            $query = "INSERT INTO $this->table($keys) VALUES($values);";

            array_push($results ,$query);
        }

        $this->save($results);
    }
}
