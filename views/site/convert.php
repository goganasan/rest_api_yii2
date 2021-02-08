<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = 'Contact';
$this->params['breadcrumbs'][] = $this->title;
?>
<form method="post" action="http://localhost/currency-exchange/api/v1/convert">
    <input name="currency_from">
    <input name="currency_to">
    <input name="value">
    <input type="submit">
</form>