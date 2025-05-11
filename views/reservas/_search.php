<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\ReservasSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="reservas-search" style="max-width: 500px; margin: 0 auto;">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1,
            'class' => 'd-flex flex-column align-items-center',
        ],
    ]); ?>

    <!-- Campo de búsqueda -->
    <div class="mb-3 w-100">
        <?= $form->field($model, 'globalSearch')->textInput([
            'placeholder' => 'Buscar...',
            'class' => 'form-control',
            'style' => 'border-radius: 0.5rem; padding: 0.5rem;',
        ])->label(false) ?>
    </div>

    <!-- Contenedor de botones -->
    <div class="d-flex justify-content-between w-100">
        <?= Html::submitButton(Yii::t('app', 'Buscar'), ['class' => 'btn btn-primary btn-sm me-2 w-48']) ?>
        <?= Html::resetButton(Yii::t('app', 'Limpiar'), ['class' => 'btn btn-outline-secondary btn-sm w-48']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
