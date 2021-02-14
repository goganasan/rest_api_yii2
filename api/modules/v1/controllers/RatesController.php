<?php
 
namespace app\api\modules\v1\controllers;

use Yii;
use app\api\modules\v1\models\Rates;
use yii\rest\Controller;

/**
 * Api controller, return blockchain currency. Check GET parameters, 
 * if isset country code return currency for one country, 
 * and if not parameters return all currencies
 * 
 * @author Krulikovskiy Igor
 */ 
class RatesController extends ApiController
{
    public $modelClass = 'app\api\modules\v1\models\Rates';
    
    /**
     * First part of my task
     *
     * @return array
     */
    public function actionIndex() 
    {
    	$ratesFromSrc = Rates::getCurrencyFromSrc();
        $countiesNamesArray = array_keys($ratesFromSrc);
        
        if (!empty(Yii::$app->request->get('currency')) && in_array(Yii::$app->request->get('currency'),$countiesNamesArray)) {
            return Rates::getOneCurrency(Yii::$app->request->get('currency'),$ratesFromSrc);
        } else {
            asort($ratesFromSrc);
            return $ratesFromSrc;
        }    
    }
}