<?php


namespace App\Services;

use SplFileObject;

abstract class ParserCSV
{
    private $header;
    private $data = [];

    public function __construct($file)
    {
        $file = new SplFileObject($file);

        foreach ($file as $str) {
            if (!$file->eof()) {
                array_push($this->data, $str);
            }
        }

        $this->header = array_shift($this->data);
    }

    protected function toString(array $arr): string
    {
        $str = fputcsv($arr);

        return $str;
    }

    protected function toArray(string $str): array
    {
        $arr = str_getcsv($str);

        return $arr;
    }

    protected function toQuotes()
    {
        $result = [];

        foreach ($this->data as $key) {
            $key = $this->toArray($key);
            $arr = [];

            foreach($key as $elem => $value) {

                $value = '"' . $value . '"';

                $arr += [$elem => $value];
            }

            array_push($result, $arr);
        }

        return $result;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function getHeader(): string
    {
        return $this->header;
    }

    public function test()
    {
        $arr = [];

        foreach ($this->data as $elem) {
            $elem = $this->toArray($elem);
            array_push($arr, $elem);
        }

        return $arr;
    }

    abstract function getSQL();
}
