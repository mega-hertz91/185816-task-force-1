<?php


namespace App\Services;


class SeedComment extends ParserCSV
{
    protected $keys = ['user_id, description, task_id'];
    protected $table = 'comment';

    public function getSQL()
    {
        $results = [];

        // TODO: Implement getSQL() method.

        foreach ($this->toQuotes() as $arr) {
            $values = $this->toString($arr);
            $keys = $this->toString($this->keys);
            $query = "INSERT INTO $this->table($keys) VALUES({$this->getRandomID(1, 20)}, $values, {$this->getRandomID(1, 10)});";

            array_push($results ,$query);
        }

        $this->save($results);
    }
}
