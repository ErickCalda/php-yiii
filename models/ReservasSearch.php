<?php
namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Reservas;

class ReservasSearch extends Reservas
{
    public $globalSearch; // ✅ Campo de búsqueda general

    public function rules()
    {
        return [
            [['id', 'laboratorio_id', 'usuario_id'], 'integer'],
            [['fecha', 'hora_inicio', 'hora_fin', 'estado', 'globalSearch'], 'safe'], // ✅ Añadido
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params, $formName = null)
    {
        $query = Reservas::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false, // ✅ Desactiva paginación si quieres scroll infinito
        ]);

        $this->load($params, $formName);

        if (!$this->validate()) {
            return $dataProvider;
        }

        if (!empty($this->globalSearch)) {
            $query->andFilterWhere([
                'or',
                ['like', 'id', $this->globalSearch],
                ['like', 'laboratorio_id', $this->globalSearch],
                ['like', 'usuario_id', $this->globalSearch],
                ['like', 'fecha', $this->globalSearch],
                ['like', 'hora_inicio', $this->globalSearch],
                ['like', 'hora_fin', $this->globalSearch],
                ['like', 'estado', $this->globalSearch],
            ]);
        } else {
            $query->andFilterWhere([
                'id' => $this->id,
                'laboratorio_id' => $this->laboratorio_id,
                'usuario_id' => $this->usuario_id,
                'fecha' => $this->fecha,
                'hora_inicio' => $this->hora_inicio,
                'hora_fin' => $this->hora_fin,
            ]);

            $query->andFilterWhere(['like', 'estado', $this->estado]);
        }

        return $dataProvider;
    }
}
