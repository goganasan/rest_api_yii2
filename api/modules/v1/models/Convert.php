<?php

namespace app\api\modules\v1\models;

use Yii;
use yii\base\Model;

/**
 * first part of my task 
 * 
 * @author Krulikovskiy
 */ 
class Convert extends Model
{
    use \app\api\common\traits\GetCurrencyRawTrait;
    
    /**
     * Return converted currency 
     *
     * @param string $currencyFrom
     * @param string $currencyTo
     * @param float $value
     * @param array $dataArray
     * @return array
     */ 
    public static function convertingResponse($currencyFrom, $currencyTo, float $value, iterable $dataArray) {
        $currentValue = self::currentValue($currencyFrom, $currencyTo, $dataArray);
        
        if ($currencyFrom == 'BTC') {
            $rate = round($currentValue['last'] * $value, 2);           
        } else {
            $rate = round($value/$currentValue['last'], 10);
        }
            
        return [
                'currency_from' => $currencyFrom,
                'currency_to' => $currencyTo,
                'value' => $value,
                'converted_value' => $value,
                'rate' => $rate
        ];
    }
    
    /**
     * Forming JSON response structure 
     *
     * @param string $currencyCode
     * @param array $dataArray
     * @return array
     */
    public static function currentValue($currencyFrom, $currencyTo, iterable $dataArray) {  
        $currencyCode = $currencyFrom === 'BTC' ? $currencyTo : $currencyFrom;
        foreach ($dataArray as $key => $value) { 
            if ($key == $currencyCode) {
                return $value;
            } 
        }
    }
}