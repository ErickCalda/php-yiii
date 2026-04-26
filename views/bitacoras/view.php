<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Bitacoras $model */

$this->title = $model->titulo;
$this->params['breadcrumbs'][] = ['label' => 'Bitácoras', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<div class="bitacoras-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Seguro que deseas eliminar este registro?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [

            'id',

            [
                'label' => 'Título',
                'value' => $model->titulo,
            ],

            [
                'label' => 'Laboratorio',
                'value' => $model->laboratorio->nombre ?? 'N/A',
            ],

            [
                'label' => 'Usuario',
                'value' => $model->usuario->nombre . ' ' . $model->usuario->apellido ?? 'N/A',
            ],

            [
                'label' => 'Tipo de Evento',
                'value' => $model->tipoEvento->nombre ?? 'N/A',
            ],

            [
                'label' => 'Estado',
                'value' => $model->estado->nombre ?? 'N/A',
            ],

            [
                'attribute' => 'descripcion',
                'format' => 'ntext',
            ],

            [
                'label' => 'Fecha del Evento',
                'attribute' => 'fecha_evento',
                'format' => 'datetime',
            ],

            [
                'label' => 'Creado',
                'attribute' => 'fecha_creacion',
                'format' => 'datetime',
            ],

            [
                'label' => 'Actualizado',
                'attribute' => 'fecha_actualizacion',
                'format' => 'datetime',
            ],
        ],
    ]) ?>

</div>