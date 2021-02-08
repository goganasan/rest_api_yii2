<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Check Access';
$this->params['breadcrumbs'][] = $this->title;
?>
<form method="post" action="http://localhost/currency-exchange/api/v1/users/login">
    <input name="username">
    <input name="password">
    <input type="submit">
</form>