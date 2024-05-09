<?php

namespace App\Helpers;

use Illuminate\Http\Request;

class HousingHelper
{
    /**
     * İkinci el konutları türlerine göre sayar.
     *
     * @param \Illuminate\Support\Collection $housings
     * @return array
     */
    public static function calculateCounts($housings)
    {
        $counts = [
            'satilik' => 0,
            'kiralik' => 0,
            'gunluk-kiralik' => 0,
        ];

        foreach ($housings as $housing) {
            $sold = $housing->sold;
            $isOffSale = isset(json_decode($housing->housing_type_data)->off_sale1[0]);
            if (!$isOffSale && (($sold && $sold != '1') || (!$sold))) {
                if (in_array($housing->step2_slug, array_keys($counts))) {
                    $counts[$housing->step2_slug]++;
                }
            }
        }

        return $counts;
    }

    /**
     * Bir URL'ye sorgu parametreleri ekler.
     *
     * @param string $paramName
     * @param mixed $paramValue
     * @return string
     */
    public static function addQueryParamToUrl($paramName, $paramValue)
    {
        $queryParams = request()->query();
        $queryParams[$paramName] = $paramValue;

        return request()->url() . '?' . http_build_query($queryParams);
    }

    /**
     * Bir konutun belirli bir filtre için görünür olup olmadığını kontrol eder.
     *
     * @param mixed $housing
     * @param string $filter
     * @return bool
     */
    public static function isHousingVisible($housing, $filter)
    {
        $sold = $housing->sold;
        $isOffSale = isset(json_decode($housing->housing_type_data)->off_sale1[0]);

        if ($isOffSale) {
            return false;
        }

        if (($sold && $sold == '1') || (!$sold)) {
            if ($filter === 'tumu') {
                return true;
            }

            return $filter === $housing->step2_slug;
        }

        return false;
    }
}
