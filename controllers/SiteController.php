<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionConvert()
    {
        return $this->render('convert');
    }

    public function actionCheckAccess()
    {
        return $this->render('check_access');
    }
    
    public function actionSendPost()
    {
        $postdata = array(
            'currencyFrom' => 'BTC',
            'currencyTo' => 'usd',
            'value' => 0.01
        );
        $postdata = json_encode($postdata);
        $ch = curl_init('http://localhost/currency-exchange/api/v1/convert');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
              'Content-Type: application/json',
              'Authorization: Bearer CyKieUrNrQrQymnal5LyLF4TUOIpIyUl')
          );
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        $output = curl_exec($ch);
        var_dump($output); die;
        if ($output === FALSE) {
            echo "cURL Error: " . curl_error($ch);
            return;
        }
        print_r($output);
        curl_close($ch);
    }
    
    public function actionSendGet()
    {
        $ch = curl_init('http://localhost/currency-exchange/api/v1/rates');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
              'Content-Type: application/json',
              'Authorization: Bearer CyKieUrNrQrQymnal5LyLF4TUOIpIyUl')
          );
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        $output = curl_exec($ch);
        var_dump($output); die;
        if ($output === FALSE) {
            echo "cURL Error: " . curl_error($ch);
            return;
        }
        print_r($output);
        curl_close($ch);
    }
}
