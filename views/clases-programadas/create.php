<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\ClasesProgramadas $model */

$this->title = 'Nueva Reserva';
$this->params['breadcrumbs'][] = [
    'label' => 'Clases Programadas',
    'url' => ['index']
];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="clases-programadas-create">

    <h1 class="page-title">
        <?= Html::encode($this->title) ?>
    </h1>



    <div class="info-time">
     <strong>Importante:</strong> Después de crear una reserva tendrás 
        <strong>10 minutos</strong> para editarla o cancelarla.
    </div>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

<style>

.page-title{
    margin:0;
    font-size:32px;
    font-weight:800;
    color:#0F172A;
    letter-spacing:-0.5px;
}

.page-subtitle{
    margin:8px 0 22px;
    font-size:15px;
    color:#64748B;
    font-weight:500;
}

.info-time{
    margin-bottom:24px;
    padding:14px 16px;
 
   
    color:#787878;
    font-size:14px;
    font-weight:600;
}

</style>