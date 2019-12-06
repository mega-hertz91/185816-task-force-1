<?php


namespace App\Services;

use SplFileObject;

class ParserCSV extends SplFileObject
{
    public $header;

    public function getArray(): array
    {
        $data = [];
        $current = 0;

        foreach ($this as $key) {
            if (!$this->eof()) {
                if($current === 0) {
                    $this->header = $key;
                } else {
                    array_push($data, str_getcsv($key));
                }

                $current++;
            }

        }

        return $data;
    }

    public function getSQL(): void
    {
        $into = '';
        $count = 0;
        $data = [];

        $table = explode('.', $this->getFilename());
        $table = array_shift($table);

        foreach ($this as $elem) {
           if(!$this->eof()) {
               $values = $elem;
               if ($count === 0) {
                   $into = $elem;
               } else {
                   $data[] = "INSERT INTO $table ($into) VALUES ($values)";
               }

               $count++;
           }
        }

        file_put_contents("$table.sql", implode(';', $data));
    }
}
