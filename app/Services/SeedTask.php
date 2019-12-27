<?php


namespace App\Services;



class SeedTask extends ParserCSV
{
    protected $keys = ['category_id, description, created_at, title, city_id, user_id, executor_id, amount, rating, status_id'];
    protected $table = 'task';

    public function getSQL()
    {
        $results = [];

        // TODO: Implement getSQL() method.

        foreach ($this->toQuotes() as $arr) {
            array_shift($arr);
            array_pop($arr);
            array_pop($arr);
            array_pop($arr);
            array_pop($arr);
            $values = $this->toString($arr);
            $keys = $this->toString($this->keys);
            $query = "INSERT INTO $this->table($keys) VALUES($values, {$this->getRandomID(1, 100)}, {$this->getRandomID(1, 20)}, {$this->getRandomID(1, 20)}, {$this->getRandomID(5000, 10000)}, {$this->getRandomID(0, 5)}, {$this->getRandomID(1,5)});";

            array_push($results ,$query);
        }

       $this->save($results);
    }
}
