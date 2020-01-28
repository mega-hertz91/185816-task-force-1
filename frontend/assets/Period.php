<?php


namespace frontend\assets;

class Period
{
    const DAY = 86400;
    const WEEK = 604800;
    const MONTH = 2629743;

    public static function getNow()
    {
        return strtotime('now');
    }

    public static function getDay()
    {
        $diff = self::getNow() - self::DAY;
        return date('Y-m-d H:i:s', $diff);
    }

    public static function getWeek()
    {
        $diff = self::getNow() - self::WEEK;
        return date('Y-m-d H:i:s', $diff);
    }

    public static function getMonth()
    {
        $diff = self::getNow() - self::MONTH;
        return date('Y-m-d H:i:s', $diff);
    }

    public static function getAll()
    {
        return 0;
    }
}
