<?php
namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\IdentityInterface;
use app\models\Usuarios;

class LoginForm extends Model implements IdentityInterface
{
    public $correo; // Asegúrate de que esta propiedad coincide con el formulario

    public $password;
    public $rememberMe = true;

    private $_user;

    // Reglas de validación
    public function rules()
    {
        return [
            [['correo', 'password'], 'required'],
            ['rememberMe', 'boolean'],
            ['password', 'validatePassword'],
            ['correo', 'email'], // Asegúrate de que el campo 'correo' sea válido
        ];
    }

    // Validación de la contraseña
    public function validatePassword($attribute)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !Yii::$app->security->validatePassword($this->password, $user->password_hash)) {
                $this->addError($attribute, 'Correo o contraseña incorrectos.');
            }
        }
    }

    // Login
    public function login()
    {
        if ($this->validate()) {
            // Intenta iniciar sesión con el usuario obtenido
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        }
        return false;
    }

    // Obtener el usuario de la base de datos por el correo
    protected function getUser()
    {
        if ($this->_user === null) {
            // Aquí estamos usando $this->correo en lugar de $this->email
            $this->_user = Usuarios::findOne(['email' => $this->correo]); // Asegúrate que el campo en la base de datos sea 'email'
        }

        return $this->_user;
    }

    // Métodos requeridos por IdentityInterface

    // Obtener la identidad por su ID (generalmente el ID de usuario)
    public static function findIdentity($id)
    {
        return Usuarios::findOne($id); // Buscar al usuario por su ID
    }

    // Obtener la identidad por el token de acceso
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null; // Retorna null si no usas token para autenticación
    }

    // Obtener el ID del usuario (normalmente es el campo ID de la base de datos)
    public function getId()
    {
        return $this->_user->id;  // Usar el ID del modelo de la base de datos
    }

    // Obtener el authKey
    public function getAuthKey()
    {
        return $this->_user->authKey;  // Asegúrate de tener un campo authKey en la base de datos
    }

    // Validar el authKey
    public function validateAuthKey($authKey)
    {
        return $this->_user->authKey === $authKey;  // Comparar el authKey con el valor en la base de datos
    }
}
