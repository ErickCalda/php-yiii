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

            // Campos obligatorios
            [
                [
                    'laboratorio_id',
                    'tipo_evento_id',
                    'titulo',
                    'descripcion',
                    'fecha_evento'
                ],
                'required'
            ],

            // Enteros
            [
                [
                    'clase_programada_id',
                    'laboratorio_id',
                    'usuario_id',
                    'tipo_evento_id',
                    'estado_id'
                ],
                'integer'
            ],

            // Texto largo
            [['descripcion'], 'string'],

            // Fechas
            [
                [
                    'fecha_evento',
                    'fecha_creacion',
                    'fecha_actualizacion'
                ],
                'safe'
            ],

            // Texto corto
            [['titulo'], 'string', 'max' => 150],
        ];
    }

    public function attributeLabels()
    {
        return [
            'clase_programada_id' => 'Clase Programada',
            'laboratorio_id'      => 'Laboratorio',
            'usuario_id'          => 'Usuario',
            'tipo_evento_id'      => 'Tipo de Evento',
            'estado_id'           => 'Estado',
            'titulo'              => 'Título',
            'descripcion'         => 'Descripción',
            'fecha_evento'        => 'Fecha del Evento',
            'fecha_creacion'      => 'Fecha Creación',
            'fecha_actualizacion' => 'Última Actualización',
        ];
    }

    public function beforeSave($insert)
    {
        if ($insert) {

            // Usuario logueado automático
            $this->usuario_id = Yii::$app->user->id;

            // Estado por defecto
            if (empty($this->estado_id)) {
                $this->estado_id = 1;
            }

            // Fecha creación
            $this->fecha_creacion = date('Y-m-d H:i:s');
        }

        // Fecha actualización
        $this->fecha_actualizacion = date('Y-m-d H:i:s');

        return parent::beforeSave($insert);
    }

    /* =====================================
     * RELACIONES
     * ===================================== */

    public function getClaseProgramada()
    {
        return $this->hasOne(ClasesProgramadas::class, [
            'id' => 'clase_programada_id'
        ]);
    }

    public function getLaboratorio()
    {
        return $this->hasOne(Laboratorios::class, [
            'id' => 'laboratorio_id'
        ]);
    }

    public function getUsuario()
    {
        return $this->hasOne(Usuarios::class, [
            'id' => 'usuario_id'
        ]);
    }

    public function getTipoEvento()
    {
        return $this->hasOne(CatTiposEvento::class, [
            'id' => 'tipo_evento_id'
        ]);
    }

    public function getEstado()
    {
        return $this->hasOne(CatEstadosBitacora::class, [
            'id' => 'estado_id'
        ]);
    }
}