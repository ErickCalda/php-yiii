<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;

class Usuarios extends \yii\db\ActiveRecord implements IdentityInterface
{
    const ROL_ADMIN = 'admin';
    const ROL_LABORATORISTA = 'laboratorista';
    const ESTADO_ACTIVO = 'activo';
    const ESTADO_INACTIVO = 'inactivo';
    const ESTADO_BLOQUEADO = 'bloqueado';

    public static function tableName()
    {
        return 'usuarios';
    }

    public function rules()
    {
        return [
            [['estado'], 'default', 'value' => 'activo'],
            [['nombre', 'apellido', 'correo', 'clave', 'rol'], 'required'],
            [['rol', 'estado'], 'string'],
            [['fecha_creacion', 'fecha_ultima_actualizacion'], 'safe'],
            [['nombre', 'apellido', 'correo', 'clave', 'auth_key', 'access_token'], 'string', 'max' => 255],
            ['rol', 'in', 'range' => array_keys(self::optsRol())],
            ['estado', 'in', 'range' => array_keys(self::optsEstado())],
            [['correo'], 'unique'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'nombre' => Yii::t('app', 'Nombre'),
            'apellido' => Yii::t('app', 'Apellido'),
            'correo' => Yii::t('app', 'Correo'),
            'clave' => Yii::t('app', 'Clave'),
            'rol' => Yii::t('app', 'Rol'),
            'estado' => Yii::t('app', 'Estado'),
            'fecha_creacion' => Yii::t('app', 'Fecha Creación'),
            'fecha_ultima_actualizacion' => Yii::t('app', 'Fecha Última Actualización'),
        ];
    }

    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    public function generateAccessToken()
    {
        $this->access_token = Yii::$app->security->generateRandomString();
    }

    public static function find()
    {
        return new UsuariosQuery(get_called_class());
    }

    public static function findByCorreo($correo)
    {
        return static::findOne(['correo' => $correo]);
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }

    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->clave);
    }

    public static function optsRol()
    {
        return [
            self::ROL_ADMIN => Yii::t('app', 'admin'),
            self::ROL_LABORATORISTA => Yii::t('app', 'laboratorista'),
        ];
    }

    public static function optsEstado()
    {
        return [
            self::ESTADO_ACTIVO => Yii::t('app', 'activo'),
            self::ESTADO_INACTIVO => Yii::t('app', 'inactivo'),
            self::ESTADO_BLOQUEADO => Yii::t('app', 'bloqueado'),
        ];
    }

    public function displayRol()
    {
        return self::optsRol()[$this->rol];
    }

    public function isRolAdmin()
    {
        return $this->rol === self::ROL_ADMIN;
    }

    public function setRolToAdmin()
    {
        $this->rol = self::ROL_ADMIN;
    }

    public function isRolLaboratorista()
    {
        return $this->rol === self::ROL_LABORATORISTA;
    }

    public function setRolToLaboratorista()
    {
        $this->rol = self::ROL_LABORATORISTA;
    }

    public function displayEstado()
    {
        return self::optsEstado()[$this->estado];
    }

    public function isEstadoActivo()
    {
        return $this->estado === self::ESTADO_ACTIVO;
    }

    public function setEstadoToActivo()
    {
        $this->estado = self::ESTADO_ACTIVO;
    }

    public function isEstadoInactivo()
    {
        return $this->estado === self::ESTADO_INACTIVO;
    }

    public function setEstadoToInactivo()
    {
        $this->estado = self::ESTADO_INACTIVO;
    }

    public function isEstadoBloqueado()
    {
        return $this->estado === self::ESTADO_BLOQUEADO;
    }

    public function setEstadoToBloqueado()
    {
        $this->estado = self::ESTADO_BLOQUEADO;
    }

    public static function findAllUsuarios()
    {
        return self::find()->all();
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $fechaActual = Yii::$app->formatter->asDatetime('now', 'php:Y-m-d H:i:s');
            $this->fecha_ultima_actualizacion = $fechaActual;

            if ($insert) {
                $this->fecha_creacion = $fechaActual;
                $this->generateAuthKey();
                $this->generateAccessToken();
            }

            if ($this->isAttributeChanged('clave')) {
                $this->clave = Yii::$app->security->generatePasswordHash($this->clave);
            }

            return true;
        }
        return false;
      
    }

    // Relaciones
    public function getEntradasMateriales()
    {
        return $this->hasMany(EntradasMateriales::class, ['usuario_id' => 'id']);
    }

    public function getLaboratorios()
    {
        return $this->hasMany(Laboratorios::class, ['responsable_id' => 'id']);
    }

    public function getReservas()
    {
        return $this->hasMany(Reservas::class, ['usuario_id' => 'id']);
    }
}
