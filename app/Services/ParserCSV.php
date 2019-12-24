<?php


namespace App\Services;

use SplFileObject;

abstract class ParserCSV
{
    private $header;
    private $data = [];
    private $file_extension = '.sql';

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
        $str = implode(',', $arr);

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

                $value = "'" . $value . "'";

                $arr += [$elem => $value];
            }

            array_push($result, $arr);
        }

        return $result;
    }

    protected function getRandomID(int $min, int $max): int {
        return random_int($min, $max);
    }

    protected function save(array $content): void {
        file_put_contents('DataSeed' . $this->file_extension, $content, FILE_APPEND);
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function getHeader(): string
    {
        return $this->header;
    }

    abstract function getSQL();
}
