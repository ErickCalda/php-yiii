<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "reservas".
 *
 * @property int $id
 * @property int $laboratorio_id
 * @property int|null $usuario_id
 * @property string $fecha
 * @property string $hora_inicio
 * @property string $hora_fin
 * @property string $estado
 *
 * @property Bitacoras[] $bitacoras
 * @property Laboratorios $laboratorio
 * @property Usuarios $usuario
 */
class Reservas extends \yii\db\ActiveRecord
{

    /**
     * ENUM field values
     */
    const ESTADO_PENDIENTE = 'pendiente';
    const ESTADO_APROBADA = 'aprobada';
    const ESTADO_CANCELADA = 'cancelada';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'reservas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['usuario_id'], 'default', 'value' => null],
            [['estado'], 'default', 'value' => 'pendiente'],
            [['laboratorio_id', 'fecha', 'hora_inicio', 'hora_fin'], 'required'],
            [['laboratorio_id', 'usuario_id'], 'integer'],
            [['fecha', 'hora_inicio', 'hora_fin'], 'safe'],
            [['estado'], 'string'],
            ['estado', 'in', 'range' => array_keys(self::optsEstado())],
            [['laboratorio_id'], 'exist', 'skipOnError' => true, 'targetClass' => Laboratorios::class, 'targetAttribute' => ['laboratorio_id' => 'id']],
            [['usuario_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::class, 'targetAttribute' => ['usuario_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'laboratorio_id' => Yii::t('app', 'Laboratorio ID'),
            'usuario_id' => Yii::t('app', 'Usuario ID'),
            'fecha' => Yii::t('app', 'Fecha'),
            'hora_inicio' => Yii::t('app', 'Hora Inicio'),
            'hora_fin' => Yii::t('app', 'Hora Fin'),
            'estado' => Yii::t('app', 'Estado'),
        ];
    }

    /**
     * Gets query for [[Bitacoras]].
     *
     * @return \yii\db\ActiveQuery|BitacorasQuery
     */
    public function getBitacoras()
    {
        return $this->hasMany(Bitacoras::class, ['reserva_id' => 'id']);
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
     * Gets query for [[Usuario]].
     *
     * @return \yii\db\ActiveQuery|UsuariosQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuarios::class, ['id' => 'usuario_id']);
    }

    /**
     * {@inheritdoc}
     * @return ReservasQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ReservasQuery(get_called_class());
    }


    /**
     * column estado ENUM value labels
     * @return string[]
     */
    public static function optsEstado()
    {
        return [
            self::ESTADO_PENDIENTE => Yii::t('app', 'pendiente'),
            self::ESTADO_APROBADA => Yii::t('app', 'aprobada'),
            self::ESTADO_CANCELADA => Yii::t('app', 'cancelada'),
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
    public function isEstadoPendiente()
    {
        return $this->estado === self::ESTADO_PENDIENTE;
    }

    public function setEstadoToPendiente()
    {
        $this->estado = self::ESTADO_PENDIENTE;
    }

    /**
     * @return bool
     */
    public function isEstadoAprobada()
    {
        return $this->estado === self::ESTADO_APROBADA;
    }

    public function setEstadoToAprobada()
    {
        $this->estado = self::ESTADO_APROBADA;
    }

    /**
     * @return bool
     */
    public function isEstadoCancelada()
    {
        return $this->estado === self::ESTADO_CANCELADA;
    }

    public function setEstadoToCancelada()
    {
        $this->estado = self::ESTADO_CANCELADA;
    }
}
