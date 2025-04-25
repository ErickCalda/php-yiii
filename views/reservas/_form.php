<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Reservas $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="reservas-form">

    <?php if ($model->hasErrors()): ?>
        <div class="alert alert-danger">
            <strong>Atención:</strong> Corrige los errores en el formulario.
        </div>
    <?php endif; ?>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'laboratorio_id')->textInput() ?>

    <?= $form->field($model, 'usuario_id')->textInput() ?>

    <?= $form->field($model, 'fecha')->input('date') ?>

    <?= $form->field($model, 'hora_inicio')->input('time') ?>

    <?= $form->field($model, 'hora_fin')->input('time') ?>

    <!-- Estado con opciones predeterminadas -->
    <?= $form->field($model, 'estado')->dropDownList(
        [
            'pendiente' => 'Pendiente',
            'aprobada' => 'Aprobada',
            'rechazada' => 'Rechazada'
        ],
        ['prompt' => 'Seleccionar estado']
    ) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

