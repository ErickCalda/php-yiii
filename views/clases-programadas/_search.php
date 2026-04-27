<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\ClasesProgramadasSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="clases-programadas-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'laboratorio_id') ?>

    <?= $form->field($model, 'docente_id') ?>

    <?= $form->field($model, 'materia_id') ?>

    <?= $form->field($model, 'curso_id') ?>

    <?php // echo $form->field($model, 'periodo_id') ?>

    <?php // echo $form->field($model, 'dia_semana') ?>

    <?php // echo $form->field($model, 'hora_inicio') ?>

    <?php // echo $form->field($model, 'hora_fin') ?>

    <?php // echo $form->field($model, 'estado') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
