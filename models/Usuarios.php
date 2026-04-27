<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;
use yii\db\ActiveRecord;


class Usuarios extends \yii\db\ActiveRecord implements IdentityInterface
{
    // ========================
    // ROLES (ahora por ID)
    // ========================
    // ROLES
    const ROL_ADMIN   = 1;
    const ROL_DOCENTE = 2;
    const ROL_TECNICO = 3;

    // ESTADOS
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
            [['estado'], 'default', 'value' => self::ESTADO_ACTIVO],

            [['nombre', 'apellido', 'correo', 'clave'], 'required', 'message' => ''],

            [['rol_id'], 'integer'],

            [['estado'], 'string'],

            [['fecha_creacion', 'fecha_ultima_actualizacion'], 'safe'],

            [['nombre', 'apellido', 'correo', 'clave', 'auth_key', 'access_token'], 'string', 'max' => 255],

            [['correo'], 'unique'],

            ['estado', 'in', 'range' => array_keys(self::optsEstado())],
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
            'rol_id' => Yii::t('app', 'Rol'),
            'estado' => Yii::t('app', 'Estado'),
            'fecha_creacion' => Yii::t('app', 'Fecha Creación'),
            'fecha_ultima_actualizacion' => Yii::t('app', 'Fecha Última Actualización'),
        ];
    }


    public function getRol()
{
    return $this->hasOne(Roles::class, ['id' => 'rol_id']);
}

    // ========================
    // AUTH
    // ========================
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    public function generateAccessToken()
    {
        $this->access_token = Yii::$app->security->generateRandomString();
    }

    // ========================
    // IDENTITY (Yii login)
    // ========================
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

    // ========================
    // LOGIN
    // ========================
    public static function findByCorreo($correo)
    {
        return static::findOne(['correo' => $correo]);
    }

    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->clave);
    }

    // ========================
    // ESTADOS
    // ========================
    public static function optsEstado()
    {
        return [
            self::ESTADO_ACTIVO => 'activo',
            self::ESTADO_INACTIVO => 'inactivo',
            self::ESTADO_BLOQUEADO => 'bloqueado',
        ];
    }

    public function displayEstado()
    {
        return self::optsEstado()[$this->estado] ?? $this->estado;
    }

    // ========================
    // ROLES
    // ========================
    public static function optsRol()
    {
        return [
            self::ROL_ADMIN => 'admin',
            self::ROL_LABORATORISTA => 'laboratorista',
        ];
    }

    public function getRolNombre()
    {
        return self::optsRol()[$this->rol_id] ?? 'desconocido';
    }

    public function isAdmin()
    {
        return (int)$this->rol_id === self::ROL_ADMIN;
    }

    public function isLaboratorista()
    {
        return (int)$this->rol_id === self::ROL_LABORATORISTA;
    }

    // ========================
    // BEFORE SAVE
    // ========================
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {

            $fechaActual = date('Y-m-d H:i:s');
            $this->fecha_ultima_actualizacion = $fechaActual;

            if ($insert) {
                $this->fecha_creacion = $fechaActual;
                $this->generateAuthKey();
                $this->generateAccessToken();
            }

            // Hash password si cambia
            if ($this->isAttributeChanged('clave')) {
                $this->clave = Yii::$app->security->generatePasswordHash($this->clave);
            }

            return true;
        }

        return false;
    }

    // ========================
    // RELACIONES
    // ========================
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