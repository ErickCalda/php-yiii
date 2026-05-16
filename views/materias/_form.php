<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;

?>

<?php $form = ActiveForm::begin([
    'id' => 'materia-form'
]); ?>

<?= $form->field($model, 'nombre')
    ->textInput([
        'placeholder' => 'Nombre de la materia'
    ]) ?>

<div style="margin-top:20px;">

    <?= Html::submitButton(
        'Guardar',
        ['class' => 'btn-soft']
    ) ?>

</div>

<?php ActiveForm::end(); ?>