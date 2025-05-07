<?php
namespace app\models;

use Yii;
use yii\base\Model;

class LoginForm extends Model
{
    public $correo; // <--- AÑADE ESTA LÍNEA
    public $password;
    public $rememberMe = true;

    private $_user = false;

    // Reglas de validación
    public function rules()
    {
        return [
            [['correo', 'password'], 'required'],
            ['rememberMe', 'boolean'],
            ['password', 'validatePassword'],
        ];
    }

    // Método para validar la contraseña
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Correo o contraseña incorrectos.');
            }
        }
    }

    // Método para obtener el usuario por correo
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByCorreo($this->correo); // <--- Asegúrate que exista este método en tu modelo User
        }

        return $this->_user;
    }
}
