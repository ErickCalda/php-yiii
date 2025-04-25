<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\EntradasMateriales;

/**
 * EntradasMaterialesSearch represents the model behind the search form of `app\models\EntradasMateriales`.
 */
class EntradasMaterialesSearch extends EntradasMateriales
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'material_id', 'usuario_id'], 'integer'],
            [['fecha_ingreso', 'tipo_entrada', 'proveedor', 'observaciones', 'creado_en'], 'safe'],
            [['cantidad'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     * @param string|null $formName Form name to be used into `->load()` method.
     *
     * @return ActiveDataProvider
     */
    public function search($params, $formName = null)
    {
        $query = EntradasMateriales::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params, $formName);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'material_id' => $this->material_id,
            'fecha_ingreso' => $this->fecha_ingreso,
            'cantidad' => $this->cantidad,
            'usuario_id' => $this->usuario_id,
            'creado_en' => $this->creado_en,
        ]);

        $query->andFilterWhere(['like', 'tipo_entrada', $this->tipo_entrada])
            ->andFilterWhere(['like', 'proveedor', $this->proveedor])
            ->andFilterWhere(['like', 'observaciones', $this->observaciones]);

        return $dataProvider;
    }
}
