<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ClasesProgramadas;

class ClasesProgramadasSearch extends ClasesProgramadas
{
    public function rules()
    {
        return [
            [['id', 'laboratorio_id', 'docente_id', 'materia_id', 'curso_id', 'periodo_id', 'estado'], 'integer'],
            [['dia_semana', 'hora_inicio', 'hora_fin'], 'safe'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

  public function search($params, $formName = null)
{
    $query = ClasesProgramadas::find();

    $query->joinWith([
        'laboratorios',
        'usuarios',
        'materias',
        'cursos',
        'periodosAcademicos'
    ]);

    $dataProvider = new ActiveDataProvider([
        'query' => $query,
    ]);

    $this->load($params, $formName);

    if (!$this->validate()) {
        return $dataProvider;
    }

    $query->andFilterWhere([
        'id' => $this->id,
        'laboratorio_id' => $this->laboratorio_id,
        'docente_id' => $this->docente_id,
        'materia_id' => $this->materia_id,
        'curso_id' => $this->curso_id,
        'periodo_id' => $this->periodo_id,
        'hora_inicio' => $this->hora_inicio,
        'hora_fin' => $this->hora_fin,
        'estado' => $this->estado,
    ]);

    $query->andFilterWhere(['like', 'dia_semana', $this->dia_semana]);

    return $dataProvider;
}
}