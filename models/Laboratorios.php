<?php

namespace app\models;

use Yii;

class Laboratorios extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'laboratorios';
    }

    public function rules()
    {
        return [
            [['descripcion'], 'default', 'value' => null],

            [
                ['codigo', 'nombre', 'tipo_id', 'estado_id', 'ubicacion_id', 'responsable_id', 'capacidad'],
                'required'
            ],

            [['tipo_id', 'estado_id', 'ubicacion_id', 'responsable_id', 'capacidad'], 'integer'],

            [['descripcion'], 'string'],

            [['fecha_creacion', 'fecha_actualizacion'], 'safe'],

            [['codigo'], 'string', 'max' => 30],
            [['nombre'], 'string', 'max' => 120],

            [['codigo'], 'unique'],

            // FK tipo
            [['tipo_id'], 'exist',
                'skipOnError' => true,
                'targetClass' => CatTiposLaboratorio::class,
                'targetAttribute' => ['tipo_id' => 'id']
            ],

            // FK estado
            [['estado_id'], 'exist',
                'skipOnError' => true,
                'targetClass' => CatEstadosLaboratorio::class,
                'targetAttribute' => ['estado_id' => 'id']
            ],

            // FK ubicación
            [['ubicacion_id'], 'exist',
                'skipOnError' => true,
                'targetClass' => Ubicaciones::class,
                'targetAttribute' => ['ubicacion_id' => 'id']
            ],

            // 🔥 NUEVO: FK responsable
            [['responsable_id'], 'exist',
                'skipOnError' => true,
                'targetClass' => Usuarios::class,
                'targetAttribute' => ['responsable_id' => 'id']
            ],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'codigo' => 'Código',
            'nombre' => 'Nombre',
            'tipo_id' => 'Tipo de Laboratorio',
            'estado_id' => 'Estado',
            'ubicacion_id' => 'Ubicación',
            'responsable_id' => 'Responsable', // 🔥 NUEVO
            'capacidad' => 'Capacidad',
            'descripcion' => 'Descripción',
            'fecha_creacion' => 'Fecha de Creación',
            'fecha_actualizacion' => 'Última Actualización',
        ];
    }

    // ==========================================
    // RELACIONES
    // ==========================================

    public function getTipo()
    {
        return $this->hasOne(CatTiposLaboratorio::class, ['id' => 'tipo_id']);
    }

    public function getEstado()
    {
        return $this->hasOne(CatEstadosLaboratorio::class, ['id' => 'estado_id']);
    }

    public function getUbicacion()
    {
        return $this->hasOne(Ubicaciones::class, ['id' => 'ubicacion_id']);
    }

    // 🔥 NUEVO: responsable del laboratorio
    public function getResponsable()
    {
        return $this->hasOne(Usuarios::class, ['id' => 'responsable_id']);
    }

    public function getEquipos()
    {
        return $this->hasMany(Equipos::class, ['laboratorio_id' => 'id']);
    }

    public function getMateriales()
    {
        return $this->hasMany(Materiales::class, ['laboratorio_id' => 'id']);
    }

    public function getReservas()
    {
        return $this->hasMany(Reservas::class, ['laboratorio_id' => 'id']);
    }

    public static function find()
    {
        return new LaboratoriosQuery(get_called_class());
    }

    // ==========================================
    // HELPERS
    // ==========================================

    public function getNombreCompleto()
    {
        return $this->codigo . ' - ' . $this->nombre;
    }

    public function getUbicacionTexto()
    {
        if (!$this->ubicacion) {
            return '-';
        }

        return trim(
            $this->ubicacion->edificio . ' ' .
            $this->ubicacion->bloque . ' ' .
            $this->ubicacion->piso . ' ' .
            $this->ubicacion->aula
        );
    }

    // 🔥 NUEVO: nombre del responsable
    public function getResponsableNombre()
    {
        if (!$this->responsable) {
            return 'Sin asignar';
        }

        return $this->responsable->nombre . ' ' . $this->responsable->apellido;
    }





}