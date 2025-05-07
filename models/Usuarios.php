<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "usuarios".
 *
 * @property int $id
 * @property string $nombre
 * @property string $apellido
 * @property string $correo
 * @property string $clave
 * @property string $rol
 * @property string|null $estado
 * @property string|null $fecha_creacion
 * @property string|null $fecha_ultima_actualizacion
 *
 * @property EntradasMateriales[] $entradasMateriales
 * @property Laboratorios[] $laboratorios
 * @property Reservas[] $reservas
 */
class Usuarios extends \yii\db\ActiveRecord
{

    /**
     * ENUM field values
     */
    const ROL_ADMIN = 'admin';
    const ROL_LABORATORISTA = 'laboratorista';
    const ESTADO_ACTIVO = 'activo';
    const ESTADO_INACTIVO = 'inactivo';
    const ESTADO_BLOQUEADO = 'bloqueado';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'usuarios';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['estado'], 'default', 'value' => 'activo'],
            [['nombre', 'apellido', 'correo', 'clave', 'rol'], 'required'],
            [['rol', 'estado'], 'string'],
            [['fecha_creacion', 'fecha_ultima_actualizacion'], 'safe'],
            [['nombre', 'apellido', 'correo', 'clave'], 'string', 'max' => 255],
            ['rol', 'in', 'range' => array_keys(self::optsRol())],
            ['estado', 'in', 'range' => array_keys(self::optsEstado())],
            [['correo'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
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
            'fecha_creacion' => Yii::t('app', 'Fecha Creacion'),
            'fecha_ultima_actualizacion' => Yii::t('app', 'Fecha Ultima Actualizacion'),
        ];
    }

    /**
     * Gets query for [[EntradasMateriales]].
     *
     * @return \yii\db\ActiveQuery|EntradasMaterialesQuery
     */
    public function getEntradasMateriales()
    {
        return $this->hasMany(EntradasMateriales::class, ['usuario_id' => 'id']);
    }

    /**
     * Gets query for [[Laboratorios]].
     *
     * @return \yii\db\ActiveQuery|LaboratoriosQuery
     */
    public function getLaboratorios()
    {
        return $this->hasMany(Laboratorios::class, ['responsable_id' => 'id']);
    }

    /**
     * Gets query for [[Reservas]].
     *
     * @return \yii\db\ActiveQuery|ReservasQuery
     */
    public function getReservas()
    {
        return $this->hasMany(Reservas::class, ['usuario_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return UsuariosQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UsuariosQuery(get_called_class());
    }


    /**
     * column rol ENUM value labels
     * @return string[]
     */
    public static function optsRol()
    {
        return [
            self::ROL_ADMIN => Yii::t('app', 'admin'),
            self::ROL_LABORATORISTA => Yii::t('app', 'laboratorista'),
        ];
    }

    /**
     * column estado ENUM value labels
     * @return string[]
     */
    public static function optsEstado()
    {
        return [
            self::ESTADO_ACTIVO => Yii::t('app', 'activo'),
            self::ESTADO_INACTIVO => Yii::t('app', 'inactivo'),
            self::ESTADO_BLOQUEADO => Yii::t('app', 'bloqueado'),
        ];
    }

    /**
     * @return string
     */
    public function displayRol()
    {
        return self::optsRol()[$this->rol];
    }

    /**
     * @return bool
     */
    public function isRolAdmin()
    {
        return $this->rol === self::ROL_ADMIN;
    }

    public function setRolToAdmin()
    {
        $this->rol = self::ROL_ADMIN;
    }

    /**
     * @return bool
     */
    public function isRolLaboratorista()
    {
        return $this->rol === self::ROL_LABORATORISTA;
    }

    public function setRolToLaboratorista()
    {
        $this->rol = self::ROL_LABORATORISTA;
    }

    /**
     * @return string
     */
    public function displayEstado()
    {
        return self::optsEstado()[$this->estado];
    }

    /**
     * @return bool
     */
    public function isEstadoActivo()
    {
        return $this->estado === self::ESTADO_ACTIVO;
    }

    public function setEstadoToActivo()
    {
        $this->estado = self::ESTADO_ACTIVO;
    }

    /**
     * @return bool
     */
    public function isEstadoInactivo()
    {
        return $this->estado === self::ESTADO_INACTIVO;
    }

    public function setEstadoToInactivo()
    {
        $this->estado = self::ESTADO_INACTIVO;
    }

    /**
     * @return bool
     */
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
        return self::find()->all(); // Obtiene todos los usuarios
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            // Asignar la fecha actual según la zona horaria de Ecuador
            $this->fecha_creacion = Yii::$app->formatter->asDatetime('now', 'php:Y-m-d H:i:s');
            $this->fecha_ultima_actualizacion = Yii::$app->formatter->asDatetime('now', 'php:Y-m-d H:i:s');
            
            return true;
        }
        return false;
    }
    

}
