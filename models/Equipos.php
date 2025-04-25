<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "equipos".
 *
 * @property int $id
 * @property string $nombre
 * @property string $codigo_interno
 * @property string|null $descripcion
 * @property string $estado
 * @property int $laboratorio_id
 *
 * @property Laboratorios $laboratorio
 */
class Equipos extends \yii\db\ActiveRecord
{

    /**
     * ENUM field values
     */
    const ESTADO_DISPONIBLE = 'disponible';
    const ESTADO_EN_USO = 'en uso';
    const ESTADO_EN_MANTENIMIENTO = 'en mantenimiento';
    const ESTADO_DADO_DE_BAJA = 'dado de baja';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'equipos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['descripcion'], 'default', 'value' => null],
            [['estado'], 'default', 'value' => 'disponible'],
            [['nombre', 'codigo_interno', 'laboratorio_id'], 'required'],
            [['descripcion', 'estado'], 'string'],
            [['laboratorio_id'], 'integer'],
            [['nombre'], 'string', 'max' => 150],
            [['codigo_interno'], 'string', 'max' => 50],
            ['estado', 'in', 'range' => array_keys(self::optsEstado())],
            [['codigo_interno'], 'unique'],
            [['laboratorio_id'], 'exist', 'skipOnError' => true, 'targetClass' => Laboratorios::class, 'targetAttribute' => ['laboratorio_id' => 'id']],
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
            'codigo_interno' => Yii::t('app', 'Codigo Interno'),
            'descripcion' => Yii::t('app', 'Descripcion'),
            'estado' => Yii::t('app', 'Estado'),
            'laboratorio_id' => Yii::t('app', 'Laboratorio ID'),
        ];
    }

    /**
     * Gets query for [[Laboratorio]].
     *
     * @return \yii\db\ActiveQuery|LaboratoriosQuery
     */
    public function getLaboratorio()
    {
        return $this->hasOne(Laboratorios::class, ['id' => 'laboratorio_id']);
    }

    /**
     * {@inheritdoc}
     * @return EquiposQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new EquiposQuery(get_called_class());
    }


    /**
     * column estado ENUM value labels
     * @return string[]
     */
    public static function optsEstado()
    {
        return [
            self::ESTADO_DISPONIBLE => Yii::t('app', 'disponible'),
            self::ESTADO_EN_USO => Yii::t('app', 'en uso'),
            self::ESTADO_EN_MANTENIMIENTO => Yii::t('app', 'en mantenimiento'),
            self::ESTADO_DADO_DE_BAJA => Yii::t('app', 'dado de baja'),
        ];
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
    public function isEstadoDisponible()
    {
        return $this->estado === self::ESTADO_DISPONIBLE;
    }

    public function setEstadoToDisponible()
    {
        $this->estado = self::ESTADO_DISPONIBLE;
    }

    /**
     * @return bool
     */
    public function isEstadoEnUso()
    {
        return $this->estado === self::ESTADO_EN_USO;
    }

    public function setEstadoToEnUso()
    {
        $this->estado = self::ESTADO_EN_USO;
    }

    /**
     * @return bool
     */
    public function isEstadoEnMantenimiento()
    {
        return $this->estado === self::ESTADO_EN_MANTENIMIENTO;
    }

    public function setEstadoToEnMantenimiento()
    {
        $this->estado = self::ESTADO_EN_MANTENIMIENTO;
    }

    /**
     * @return bool
     */
    public function isEstadoDadoDeBaja()
    {
        return $this->estado === self::ESTADO_DADO_DE_BAJA;
    }

    public function setEstadoToDadoDeBaja()
    {
        $this->estado = self::ESTADO_DADO_DE_BAJA;
    }
}
