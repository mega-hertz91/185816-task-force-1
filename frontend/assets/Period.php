<?php


namespace frontend\assets;

class Period
{
    const DAY = 86400;
    const WEEK = 604800;
    const MONTH = 2629743;

    public static function getNow(): int
    {
        return strtotime('now');
    }

    public static function getDay(): string
    {
        $diff = self::getNow() - self::DAY;
        return date('Y-m-d H:i:s', $diff);
    }

    public static function getWeek(): string
    {
        $diff = self::getNow() - self::WEEK;
        return date('Y-m-d H:i:s', $diff);
    }

    public static function getMonth(): string
    {
        $diff = self::getNow() - self::MONTH;
        return date('Y-m-d H:i:s', $diff);
    }

    public static function getAll(): int
    {
        return 0;
    }
}
