<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Usuarios;

class UsuariosSearch extends Usuarios
{
    public function rules()
    {
        return [
            [['id', 'rol_id'], 'integer'],

            [['nombre', 'apellido', 'correo', 'estado', 'fecha_creacion', 'fecha_ultima_actualizacion'], 'safe'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params, $formName = null)
    {
        $query = Usuarios::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params, $formName);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // ========================
        // FILTROS EXACTOS
        // ========================
        $query->andFilterWhere([
            'id' => $this->id,
            'rol_id' => $this->rol_id,
            'fecha_creacion' => $this->fecha_creacion,
            'fecha_ultima_actualizacion' => $this->fecha_ultima_actualizacion,
        ]);

        // ========================
        // FILTROS LIKE
        // ========================
        $query->andFilterWhere(['like', 'nombre', $this->nombre])
            ->andFilterWhere(['like', 'apellido', $this->apellido])
            ->andFilterWhere(['like', 'correo', $this->correo])
            ->andFilterWhere(['like', 'estado', $this->estado]);

        return $dataProvider;
    }
}