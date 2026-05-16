<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;

?>

<?php $form = ActiveForm::begin([
    'id' => 'periodo-form'
]); ?>

<?= $form->field($model, 'nombre')
    ->textInput([
        'placeholder' => 'Ej: 2026-A'
    ]) ?>

<div style="margin-top:20px;">

    <?= Html::submitButton(
        'Guardar',
        ['class' => 'btn-soft']
    ) ?>

</div>

<?php ActiveForm::end(); ?>