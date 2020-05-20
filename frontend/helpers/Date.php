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

    /**
     * @param $timeDiff
     * @return string
     * @throws \Exception
     */

    public  static function getTimeHasPassed($timeDiff)
    {
        $currentDate = new \DateTime();
        $timeDiff = new \DateTime($timeDiff);
        $diff = $currentDate->diff($timeDiff);
        $result = '';

        if (!isset($timeDiff)) {
            throw new \Exception('Поле дата пустое');
        }

        if (isset($diff->d) && $diff->d > 4 && $diff->d !== 0) {
            $result = 'Несколько дней назад';
        } else {
            $result = $diff->d . 'дня назад';
        }

        if ($diff->d === 0 && $diff->h !== 0) {
            $result = $diff->h . ' часов назад';
        }

        if ($diff->h === 0 && $diff->i !== 0) {
            $result = $diff->i . ' минут назад';
        }

        return $result ;
    }
}
