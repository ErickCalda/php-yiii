<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Usuarios $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="usuarios-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'apellido')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'correo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'clave')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'rol')->dropDownList([ 'admin' => 'Admin', 'laboratorista' => 'Laboratorista', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'estado')->dropDownList([ 'activo' => 'Activo', 'inactivo' => 'Inactivo', 'bloqueado' => 'Bloqueado', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'fecha_creacion')->textInput(['readonly' => true, 'value' => $model->fecha_creacion ? $model->fecha_creacion : date('Y-m-d H:i:s')]) ?>

<?= $form->field($model, 'fecha_ultima_actualizacion')->textInput(['readonly' => true, 'value' => $model->fecha_ultima_actualizacion ? $model->fecha_ultima_actualizacion : date('Y-m-d H:i:s')]) ?>


    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
