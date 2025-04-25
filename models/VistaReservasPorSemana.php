<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vista_reservas_por_semana".
 * Este modelo corresponde a una vista de base de datos
 *
 * @property int $reserva_id
 * @property string $fecha
 * @property string $hora_inicio
 * @property string $hora_fin
 * @property string $laboratorio
 * @property string $usuario_responsable
 * @property string $estado
 */
class VistaReservasPorSemana extends \yii\db\ActiveRecord
{
    const ESTADO_PENDIENTE = 'pendiente';
    const ESTADO_APROBADA = 'aprobada';
    const ESTADO_CANCELADA = 'cancelada';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        // Aseguramos que se use la vista en lugar de una tabla normal.
        return 'vista_reservas_por_semana';
    }

    /**
     * Desactivamos la necesidad de una clave primaria para la vista.
     */
    public static function primaryKey()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['reserva_id'], 'integer'],
            [['fecha', 'hora_inicio', 'hora_fin', 'laboratorio', 'usuario_responsable'], 'required'],
            [['fecha', 'hora_inicio', 'hora_fin'], 'safe'],
            [['estado'], 'string'],
            [['laboratorio'], 'string', 'max' => 100],
            [['usuario_responsable'], 'string', 'max' => 255],
            ['estado', 'in', 'range' => array_keys(self::optsEstado())],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'reserva_id' => Yii::t('app', 'ID de Reserva'),
            'fecha' => Yii::t('app', 'Fecha'),
            'hora_inicio' => Yii::t('app', 'Hora de Inicio'),
            'hora_fin' => Yii::t('app', 'Hora de Fin'),
            'laboratorio' => Yii::t('app', 'Laboratorio'),
            'usuario_responsable' => Yii::t('app', 'Responsable'),
            'estado' => Yii::t('app', 'Estado'),
        ];
    }

    /**
     * Opciones para el campo estado
     */
    public static function optsEstado()
    {
        return [
            self::ESTADO_PENDIENTE => Yii::t('app', 'Pendiente'),
            self::ESTADO_APROBADA => Yii::t('app', 'Aprobada'),
            self::ESTADO_CANCELADA => Yii::t('app', 'Cancelada'),
        ];
    }

    public function displayEstado()
    {
        return self::optsEstado()[$this->estado] ?? $this->estado;
    }

    public function isEstadoPendiente()
    {
        return $this->estado === self::ESTADO_PENDIENTE;
    }

    public function isEstadoAprobada()
    {
        return $this->estado === self::ESTADO_APROBADA;
    }

    public function isEstadoCancelada()
    {
        return $this->estado === self::ESTADO_CANCELADA;
    }

    public function setEstadoToPendiente()
    {
        $this->estado = self::ESTADO_PENDIENTE;
    }

    public function setEstadoToAprobada()
    {
        $this->estado = self::ESTADO_APROBADA;
    }

    public function setEstadoToCancelada()
    {
        $this->estado = self::ESTADO_CANCELADA;
    }

    /**
     * Esto es necesario porque las vistas generalmente no permiten operaciones
     * de escritura (INSERT, UPDATE, DELETE), por lo tanto, especificamos esto.
     * Evitamos que Yii intente insertar, actualizar o eliminar en esta vista.
     */
    public function beforeSave($insert)
    {
        // Evitamos que el modelo se guarde en la base de datos, ya que es una vista.
        return false;
    }
}
