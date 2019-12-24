<?php


namespace App\Services;


class SeedCategory extends ParserCSV
{
    protected $keys = ['category_name, tag'];
    protected $table = 'category';

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
