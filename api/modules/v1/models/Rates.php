<?php

namespace app\api\modules\v1\models;

use Yii;
use GuzzleHttp\Client;
use yii\base\Model;

/**
 * first part of my task 
 * 
 * @author Krulikovskiy Igor
 */ 
class Rates extends Model
{
    use \app\api\common\traits\GetCurrencyRawTrait;
    /**
     * Return one currency if isset GET parameter
     *
     * @param string $country
     * @param array $currensiesRates
     * @return array
     */
    public static function getOneCurrency($country, iterable $currensiesRates) {
        foreach ($currensiesRates as $key => $value) {
            if ($key === $country) {
                return $value;
            }
        }
    }
    
    /**
     * Forming JSON response structure 
     *
     * @param int $code
     * @param array $dataArray
     * @return array
     */
    public static function formingResponse($code, iterable $dataArray) {
        asort($dataArray);
        if ($code == 200) {
            return [
                'status' => 'success', 
                'code' => $code,
                'data' => $dataArray
            ];
        }
    }
}