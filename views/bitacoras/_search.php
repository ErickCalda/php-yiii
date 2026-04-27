<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\BitacorasSearch $model */
/** @var yii\widgets\ActiveForm $form */

?>

<div class="bitacoras-search">

<?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    'options' => [
        'data-pjax' => 1,
        'autocomplete' => 'off'
    ],
]); ?>

<div class="row g-3">

    <div class="col-md-2">
        <?= $form->field($model, 'id')->textInput([
            'placeholder' => 'ID'
        ]) ?>
    </div>

    <div class="col-md-3">
        <?= $form->field($model, 'clase_programada_id')->textInput([
            'placeholder' => 'Clase'
        ]) ?>
    </div>

    <div class="col-md-3">
        <?= $form->field($model, 'laboratorio_id')->textInput([
            'placeholder' => 'Laboratorio'
        ]) ?>
    </div>

    <div class="col-md-4">
        <?= $form->field($model, 'descripcion')->textInput([
            'placeholder' => 'Buscar descripción...'
        ]) ?>
    </div>

    <div class="col-md-4">
        <?= $form->field($model, 'titulo')->textInput([
            'placeholder' => 'Buscar título...'
        ]) ?>
    </div>

    <div class="col-md-4">
        <?= $form->field($model, 'fecha_evento')->input('date') ?>
    </div>

</div>

<div class="form-group mt-3 d-flex gap-2">

    <?= Html::submitButton(
        'Buscar',
        ['class' => 'btn btn-primary']
    ) ?>

    <?= Html::resetButton(
        'Limpiar',
        ['class' => 'btn btn-outline-secondary']
    ) ?>

</div>

<?php ActiveForm::end(); ?>

</div>