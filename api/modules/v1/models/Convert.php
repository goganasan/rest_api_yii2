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
class Convert extends Model
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
     * Return converted currency 
     *
     * @param string $currency_from
     * @param string $currency_to
     * @param float $value
     * @param array $dataArray
     * @return array
     */
    public static function convertingResponse($currency_from, $currency_to, float $value, iterable $dataArray) {
        if ($dataArray['code'] == 200) {
            foreach ($dataArray['data'] as $key => $value) {
                if ($key === $currency_from) {
                    $from = $value;
                } 
                if ($key === $currency_to) {
                    $to = $value;
                }
            }
            
            if ($currency_from == 'BTC') {
                round($rate = $from['last'] * $value * Yii::$app->params['buyCommission'], 2);           
            } else {
                round($rate = $value/$to['last'] * Yii::$app->params['saleCommission'], 10);
            }
            
            return self::formingResponse($dataArray['code'], $currency_from, $currency_to, $value, $rate);
        }     
    }
    
    /**
     * Forming JSON response structure 
     *
     * @param int $code
     * @param array $dataArray
     * @return array
     */
    public static function formingResponse($code, $currency_from, $currency_to, float $value, float $rate) {
        if ($code == 200) {
            return [
                'status' => 'success', 
                'code' => $code,
                'currency_from' => $currency_from,
                'currency_to' => $currency_to,
                'value' => $value,
                'rate' => $rate
            ];
        } else {
            return [
                'status' => 'success', 
                'code' => 421,
                'message' => 'Bad parameters',
            ];
        }
    }
       
}