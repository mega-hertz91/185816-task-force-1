<?php


namespace App\Services;

class SeedUser extends ParserCSV
{
    public function getSQL()
    {
        // TODO: Implement getSQL() method.

        return $this->toQuotes();

    }
}