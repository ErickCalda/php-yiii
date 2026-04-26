<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Bitacoras;

class BitacorasSearch extends Bitacoras
{
    public function rules()
    {
        return [
            [
                [
                    'id',
                    'reserva_id',
                    'laboratorio_id',
                    'usuario_id',
                    'tipo_evento_id',
                    'estado_id'
                ],
                'integer'
            ],

            [
                [
                    'titulo',
                    'descripcion',
                    'fecha_evento'
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
        $query = Bitacoras::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'fecha_evento' => SORT_DESC
                ]
            ]
        ]);

        $this->load($params, $formName);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // filtros exactos
        $query->andFilterWhere([
            'id' => $this->id,
            'reserva_id' => $this->reserva_id,
            'laboratorio_id' => $this->laboratorio_id,
            'usuario_id' => $this->usuario_id,
            'tipo_evento_id' => $this->tipo_evento_id,
            'estado_id' => $this->estado_id,
        ]);

        // filtros tipo búsqueda (LIKE)
        $query->andFilterWhere(['like', 'titulo', $this->titulo])
              ->andFilterWhere(['like', 'descripcion', $this->descripcion])
              ->andFilterWhere(['like', 'fecha_evento', $this->fecha_evento]);

        return $dataProvider;
    }
}