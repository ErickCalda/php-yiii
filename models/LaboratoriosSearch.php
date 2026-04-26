<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

class LaboratoriosSearch extends Laboratorios
{
    public $tipo;
    public $estado;
    public $ubicacion_texto;
    public $responsable; // 🔥 NUEVO

    public function rules()
    {
        return [
            [['id', 'tipo_id', 'estado_id', 'ubicacion_id', 'capacidad', 'responsable_id'], 'integer'],

            [
                [
                    'codigo',
                    'nombre',
                    'descripcion',
                    'tipo',
                    'estado',
                    'ubicacion_texto',
                    'responsable', // 🔥 NUEVO
                    'fecha_creacion',
                    'fecha_actualizacion'
                ],
                'safe'
            ],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params, $formName = null)
    {
        $query = Laboratorios::find()
            ->alias('l')
            ->joinWith(['tipo t', 'estado e', 'ubicacion u', 'responsable r']); // 🔥 NUEVO JOIN

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ],
                'attributes' => [
                    'id',
                    'codigo',
                    'nombre',
                    'capacidad',
                    'fecha_creacion',

                    'tipo' => [
                        'asc' => ['t.nombre' => SORT_ASC],
                        'desc' => ['t.nombre' => SORT_DESC],
                    ],

                    'estado' => [
                        'asc' => ['e.nombre' => SORT_ASC],
                        'desc' => ['e.nombre' => SORT_DESC],
                    ],

                    'ubicacion_texto' => [
                        'asc' => ['u.edificio' => SORT_ASC],
                        'desc' => ['u.edificio' => SORT_DESC],
                    ],

                    // 🔥 NUEVO: ordenar por responsable
                    'responsable' => [
                        'asc' => ['r.nombre' => SORT_ASC],
                        'desc' => ['r.nombre' => SORT_DESC],
                    ],
                ],
            ],
        ]);

        $this->load($params, $formName);

        if (!$this->validate()) {
            return $dataProvider;
        }

        /**
         * Exact filters
         */
        $query->andFilterWhere([
            'l.id' => $this->id,
            'l.tipo_id' => $this->tipo_id,
            'l.estado_id' => $this->estado_id,
            'l.ubicacion_id' => $this->ubicacion_id,
            'l.capacidad' => $this->capacidad,
            'l.responsable_id' => $this->responsable_id, // 🔥 NUEVO
        ]);

        /**
         * Text filters
         */
        $query->andFilterWhere(['like', 'l.codigo', $this->codigo])
            ->andFilterWhere(['like', 'l.nombre', $this->nombre])
            ->andFilterWhere(['like', 'l.descripcion', $this->descripcion])

            ->andFilterWhere(['like', 't.nombre', $this->tipo])
            ->andFilterWhere(['like', 'e.nombre', $this->estado])

            // 🔥 NUEVO: filtro por responsable (nombre/apellido)
            ->andFilterWhere([
                'or',
                ['like', 'r.nombre', $this->responsable],
                ['like', 'r.apellido', $this->responsable],
            ])

            ->andFilterWhere([
                'or',
                ['like', 'u.edificio', $this->ubicacion_texto],
                ['like', 'u.bloque', $this->ubicacion_texto],
                ['like', 'u.piso', $this->ubicacion_texto],
                ['like', 'u.aula', $this->ubicacion_texto],
            ]);

        return $dataProvider;
    }
}