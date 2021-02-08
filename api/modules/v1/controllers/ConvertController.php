<?php
 
namespace app\api\modules\v1\controllers;

use Yii;
use app\api\modules\v1\models\Convert;
use yii\rest\Controller;

/**
 * Api controller, return converted cerryncy
 * 
 */ 
class ConvertController extends Controller
{
    public $modelClass = 'app\api\modules\v1\models\Convert';
    
    /**
     * Second part of my task
     *
     * @return array
     */
    public function actionIndex() 
    {
    	$ratesFromSrc = Convert::getCurrencyFromSrc();
        $countiesNamesArray = array_keys($ratesFromSrc['data']);
        $postData = $Yii::$app->request->post();
        
        if (!empty($postData['currency_from']) && 
             !empty($postData['currency_to']) &&
             !empty($postData['value']) &&
             is_numeric($postData['value']) &&
             $postData['value'] >= 0.01 &&
             in_array($postData['currency_from'], $countiesNamesArray) &&
             in_array($postData['currency_to'], $countiesNamesArray)) {
            return Convert::convertingResponse($postData['currency_from'], $postData['currency_to'], $postData['value'], $ratesFromSrc);
        } 
    }
}