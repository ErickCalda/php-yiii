<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "laboratorios".
 *
 * @property int $id
 * @property string $nombre
 * @property string $ubicacion
 * @property string|null $descripcion
 * @property int|null $responsable_id
 * @property int $capacidad
 *
 * @property Equipos[] $equipos
 * @property Materiales[] $materiales
 * @property Reservas[] $reservas
 * @property Usuarios $responsable
 */
class Laboratorios extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'laboratorios';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['descripcion', 'responsable_id'], 'default', 'value' => null],
            [['nombre', 'ubicacion', 'capacidad'], 'required'],
            [['descripcion'], 'string'],
            [['responsable_id', 'capacidad'], 'integer'],
            [['nombre'], 'string', 'max' => 100],
            [['ubicacion'], 'string', 'max' => 200],
            [['nombre'], 'unique'],
            [['responsable_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::class, 'targetAttribute' => ['responsable_id' => 'id']],
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
            'ubicacion' => Yii::t('app', 'Ubicacion'),
            'descripcion' => Yii::t('app', 'Descripcion'),
            'responsable_id' => Yii::t('app', 'Responsable ID'),
            'capacidad' => Yii::t('app', 'Capacidad'),
        ];
    }

    /**
     * Gets query for [[Equipos]].
     *
     * @return \yii\db\ActiveQuery|EquiposQuery
     */
    public function getEquipos()
    {
        return $this->hasMany(Equipos::class, ['laboratorio_id' => 'id']);
    }

    /**
     * Gets query for [[Materiales]].
     *
     * @return \yii\db\ActiveQuery|MaterialesQuery
     */
    public function getMateriales()
    {
        return $this->hasMany(Materiales::class, ['laboratorio_id' => 'id']);
    }

    /**
     * Gets query for [[Reservas]].
     *
     * @return \yii\db\ActiveQuery|ReservasQuery
     */
    public function getReservas()
    {
        return $this->hasMany(Reservas::class, ['laboratorio_id' => 'id']);
    }

    /**
     * Gets query for [[Responsable]].
     *
     * @return \yii\db\ActiveQuery|UsuariosQuery
     */
    public function getResponsable()
    {
        return $this->hasOne(Usuarios::class, ['id' => 'responsable_id']);
    }

    /**
     * {@inheritdoc}
     * @return LaboratoriosQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new LaboratoriosQuery(get_called_class());
    }

}
