<?php
namespace app\api\common\traits;

use Yii;
use GuzzleHttp\Client;
use yii\web\HttpException;
/**
 * Trait parse BTC currency values from other APIes (URL in config params)
 *
 * @author Krulikovskiy
 */
trait GetCurrencyRawTrait {          
    
    /**
     * Calculate commission 
     *
     * @param array $ratesArray
     * @return array
     */
    private static function countCommission(iterable $ratesArray) {
        foreach ($ratesArray as &$rate) {
            $rate['15m'] = round($rate['15m'] * Yii::$app->params['saleCommission'], 2); 
            $rate['last'] = round($rate['last'] * Yii::$app->params['saleCommission'], 2);
            $rate['sell'] = round($rate['sell'] * Yii::$app->params['saleCommission'], 2);
            $rate['buy'] = round($rate['buy'] * Yii::$app->params['buyCommission'], 2);
        }
        return $ratesArray;
    }
    
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
        if ($code !== 200) {
            throw new HttpException(413 ,'Technical problems, sorry for inconveniences');
        }
    	return $currensiesRates;
    }
}
