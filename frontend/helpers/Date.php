<?php


namespace frontend\helpers;

use DateTime;

class Date
{
    const FORMAT_BD = 'Y-m-d H:i:s';

    /***
     * @param string $date
     * @return DateTime
     * @throws \Exception
     */

    private static function getDate($date = null)
    {
        return new DateTime($date);
    }

    /***
     * @return string
     * @throws \Exception
     */

    public static function getDateNow()
    {
        return self::getDate()->format(self::FORMAT_BD);
    }

    /***
     * @param string $date
     * @return string
     * @throws \Exception
     */
    public static function getDateBase($date)
    {
        return self::getDate($date)->format(self::FORMAT_BD);
    }
}
