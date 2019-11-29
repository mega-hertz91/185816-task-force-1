<?php


namespace App\Services;

use SplFileObject;

class ParserCSV extends SplFileObject
{
    public function parseCSV()
    {
        return $this->fread($this->getSize());
    }

    public function getArray()
    {
        return explode(',', $this->parseCSV());
    }
}
