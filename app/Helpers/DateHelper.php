<?php

namespace App\Helpers;

class DateHelper
{
    /**
     * İngilizce ay ve gün isimlerini Türkçeye çevirir.
     *
     * @param string $date
     * @return string
     */
    public static function convertToTurkish($date)
    {
        $translations = [
            'January' => 'Ocak',
            'February' => 'Şubat',
            'March' => 'Mart',
            'April' => 'Nisan',
            'May' => 'Mayıs',
            'June' => 'Haziran',
            'July' => 'Temmuz',
            'August' => 'Ağustos',
            'September' => 'Eylül',
            'October' => 'Ekim',
            'November' => 'Kasım',
            'December' => 'Aralık',
            'Monday' => 'Pazartesi',
            'Tuesday' => 'Salı',
            'Wednesday' => 'Çarşamba',
            'Thursday' => 'Perşembe',
            'Friday' => 'Cuma',
            'Saturday' => 'Cumartesi',
            'Sunday' => 'Pazar',
            'Jan' => 'Oca',
            'Feb' => 'Şub',
            'Mar' => 'Mar',
            'Apr' => 'Nis',
            'May' => 'May',
            'Jun' => 'Haz',
            'Jul' => 'Tem',
            'Aug' => 'Ağu',
            'Sep' => 'Eyl',
            'Oct' => 'Eki',
            'Nov' => 'Kas',
            'Dec' => 'Ara',
        ];

        return strtr($date, $translations);
    }

    /**
     * Belirli bir tarih formatını verilen bir başka formata çevirir.
     *
     * @param string $date
     * @param string $fromFormat
     * @param string $toFormat
     * @return string
     */
    public static function convertDateFormat($date, $fromFormat, $toFormat)
    {
        $datetime = \DateTime::createFromFormat($fromFormat, $date);
        if ($datetime === false) {
            throw new \Exception("Invalid date format");
        }

        return $datetime->format($toFormat);
    }

    /**
     * Bir tarihi belirtildiği şekilde ekler veya çıkarır.
     *
     * @param string $date
     * @param string $interval (örneğin: "+1 day", "-3 days", "+2 months")
     * @return string
     */
    public static function modifyDate($date, $interval)
    {
        $datetime = new \DateTime($date);
        $datetime->modify($interval);

        return $datetime->format('Y-m-d');
    }
}
