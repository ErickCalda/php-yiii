<?php

namespace app\models;

use Yii;

class Bitacoras extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'bitacoras';
    }

    public function rules()
    {
        return [
            [
                [
                    'reserva_id',
                    'laboratorio_id',
                    'tipo_evento_id',
                    'titulo',
                    'descripcion'
                ],
                'required'
            ],

            [
                [
                    'reserva_id',
                    'laboratorio_id',
                    'usuario_id',
                    'tipo_evento_id',
                    'estado_id'
                ],
                'integer'
            ],

            [['descripcion'], 'string'],

            // solo fechas reales del sistema
            [
                [
                    'fecha_evento',
                    'fecha_creacion',
                    'fecha_actualizacion'
                ],
                'safe'
            ],

            [['titulo'], 'string', 'max' => 150],
        ];
    }

    public function attributeLabels()
    {
        return [
            'reserva_id' => 'Reserva',
            'laboratorio_id' => 'Laboratorio',
            'tipo_evento_id' => 'Tipo de evento',
            'estado_id' => 'Estado',
            'titulo' => 'Título',
            'descripcion' => 'Descripción',
            'fecha_evento' => 'Fecha del evento',
        ];
    }

    public function beforeSave($insert)
    {
        if ($insert) {

            // 👤 Usuario automático
            $this->usuario_id = Yii::$app->user->id;

            // 📌 Estado por defecto
            $this->estado_id = $this->estado_id ?: 1;

            // ⏱ creación automática
            $this->fecha_creacion = date('Y-m-d H:i:s');
        }

        // ⏱ actualización automática
        $this->fecha_actualizacion = date('Y-m-d H:i:s');

        return parent::beforeSave($insert);
    }

    /* =========================
     * RELACIONES
     * ========================= */

    public function getReserva()
    {
        return $this->hasOne(Reservas::class, ['id' => 'reserva_id']);
    }

    public function getLaboratorio()
    {
        return $this->hasOne(Laboratorios::class, ['id' => 'laboratorio_id']);
    }

    public function getUsuario()
    {
        return $this->hasOne(Usuarios::class, ['id' => 'usuario_id']);
    }

    public function getTipoEvento()
    {
        return $this->hasOne(CatTiposEvento::class, ['id' => 'tipo_evento_id']);
    }

    public function getEstado()
    {
        return $this->hasOne(CatEstadosBitacora::class, ['id' => 'estado_id']);
    }
}