<?php

namespace app\api\modules\v1\models;

use Yii;
use app\models\LoginForm;

/**
 * LoginApiForm is the model behind the login form.
 */
class Login extends LoginForm
{
    private $_user = false;

    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByUsername($this->username);
        }
        return $this->_user;
    }
}