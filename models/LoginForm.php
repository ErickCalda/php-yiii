<?php
namespace app\models;

use Yii;
use yii\base\Model;

class LoginForm extends Model
{
    public $correo;
    public $clave;
    public $rememberMe = true;

    private $_user = false;

    public function rules()
{
    return [
        [['correo', 'clave'], 'required'],
        ['rememberMe', 'boolean'],
        ['clave', 'validateClave'],
    ];
}

public function validateClave($attribute, $params)
{
    if (!$this->hasErrors()) {
        $user = $this->getUser();
        if (!$user || !$user->validatePassword($this->clave)) {
            $this->addError($attribute, 'Correo o clave incorrectos.');
        }
    }
}

    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        }
        return false;
    }

    protected function getUser()
    {
        if ($this->_user === false) {
            $this->_user = Usuarios::findByCorreo($this->correo);

        }
        return $this->_user;
    }
}
