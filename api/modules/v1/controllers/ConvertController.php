<?php
 
namespace app\api\modules\v1\controllers;

use Yii;
use app\api\modules\v1\models\Convert;
use yii\web\HttpException;

/**
 * Api controller, return converted cerryncy
 * 
 */ 
class ConvertController extends ApiController
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
        $countiesNamesArray = array_keys($ratesFromSrc);
        $postData = Yii::$app->request->post();
        if ($postData['value'] < 0.01 ||
            empty($postData['currencyFrom']) || 
            empty($postData['currencyTo']) ||
            empty($postData['value']) ||
            !is_numeric($postData['value']) ||
            in_array($postData['currencyFrom'], $countiesNamesArray) ||
            in_array($postData['currencyTo'], $countiesNamesArray)) {
            throw new HttpException(413 ,'Please check yor request, params with errors');
        }
        
        return Convert::convertingResponse(
            strtoupper($postData['currencyFrom']),
            strtoupper($postData['currencyTo']), 
            $postData['value'], $ratesFromSrc
        );
    }
}