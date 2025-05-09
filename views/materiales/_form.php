<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Materiales $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="materiales-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'unidad_medida')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cantidad')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'laboratorio_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
