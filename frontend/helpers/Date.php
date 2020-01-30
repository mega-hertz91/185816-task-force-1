<?php


namespace frontend\helpers;

use DateTime;

class Date
{
    const FORMAT_BD = 'Y-m-d H:i:s';

    private static function getDate()
    {
        return new DateTime();
    }

    public static function getDateNow()
    {
        return self::getDate()->format(self::FORMAT_BD);
    }
}
