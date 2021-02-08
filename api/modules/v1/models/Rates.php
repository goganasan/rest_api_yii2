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
    /**
     * Currency data from api source https://blockchain.info/ticker
     *
     * @return array
     */
    public static function getCurrencyFromSrc() {
        $client = new Client();
        $rates = $client->request('GET', Yii::$app->params['currencySrc']);
        $code = $rates->getStatusCode();
        $currensiesRates = self::countCommission(json_decode($rates->getBody(), true));

    	return ['code' => $code, 'data' => $currensiesRates];
    }
    
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
                return self::formingResponse(200, $value);
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
    
    /**
     * Calculate commission 
     *
     * @param array $ratesArray
     * @return array
     */
    public static function countCommission(iterable $ratesArray) {
        foreach ($ratesArray as &$rate) {
            $rate['15m'] = round($rate['15m'] * Yii::$app->params['saleCommission'], 2); 
            $rate['last'] = round($rate['last'] * Yii::$app->params['saleCommission'], 2);
            $rate['sell'] = round($rate['sell'] * Yii::$app->params['saleCommission'], 2);
            $rate['buy'] = round($rate['buy'] * Yii::$app->params['buyCommission'], 2);
        }
        return $ratesArray;
    }
    
}