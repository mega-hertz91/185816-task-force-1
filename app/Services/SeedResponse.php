<?php


namespace App\Services;


class SeedResponse extends ParserCSV
{
    protected $keys = ['user_id, amount'];
    protected $table = 'response';

    public function getSQL()
    {
        $results = [];

        // TODO: Implement getSQL() method.

        foreach ($this->toQuotes() as $arr) {
            $values = $this->toString($arr);
            $keys = $this->toString($this->keys);
            $query = "INSERT INTO $this->table($keys) VALUES({$this->getRandomID(1, 20)}, $values);";

            array_push($results ,$query);
        }

        $this->save($results);
    }
}
