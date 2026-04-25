<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Reservas;

?>

<div class="bitacoras-form">

<?php $form = ActiveForm::begin([
    'id' => 'bitacoraForm',
    'options' => ['autocomplete' => 'off']
]); ?>

<?= $form->field($model, 'reserva_id')->dropDownList(

    ArrayHelper::map(
        Reservas::find()
            ->select(['usuario_id'])
            ->distinct()
            ->with('usuario')
            ->all(),

        'usuario_id',

        function($reserva){
            return $reserva->usuario->nombre ?? 'Sin nombre';
        }
    ),

    [
        'prompt' => 'Selecciona una persona',
        'class' => 'form-control'
    ]

) ?>

<?= $form->field($model, 'descripcion')->textarea([
    'rows' => 5,
    'class' => 'form-control',
    'placeholder' => 'Describe la actividad...'
]) ?>

<?= $form->field($model, 'fecha_registro')->input('date', [
    'class' => 'form-control'
]) ?>

<div class="form-actions">

<?= Html::submitButton(
    'Guardar',
    ['class' => 'btn-save']
) ?>

</div>

<?php ActiveForm::end(); ?>

</div>