<?php

namespace app\api\modules\v1\controllers;

use Yii;
use app\api\modules\v1\models\Login;

/**
 * Description of UserController
 *
 */
class UserController extends ApiController
{
    public $modelClass = 'app\api\modules\v1\models\User';
    
    public function behaviors() 
    {
	$behaviors = parent::behaviors();
	$behaviors['authenticator']['except'] = ['login'];
	return $behaviors;         
    }
    
    public function actionLogin() 
    {
        $model = new Login();

        if ($model->load(Yii::$app->getRequest()->getBodyParams(), '') && $model->login()) {
            return ['access_token' => Yii::$app->user->identity->getAccessToken()];
        } else {
            $model->validate();
            return $model;
        }
    }
}

