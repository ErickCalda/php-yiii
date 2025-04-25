<?php

use yii\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Reservas por Semana';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="reservas-index container mt-5">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="card shadow-sm p-4 mt-4">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                'reserva_id',
                'fecha',
                'hora_inicio',
                'hora_fin',
                'laboratorio',
                'usuario_responsable',
                'estado',
            ],
        ]) ?>
    </div>
</div>
