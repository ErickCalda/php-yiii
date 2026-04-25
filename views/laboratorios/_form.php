<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Usuarios;

/** @var yii\web\View $this */
/** @var app\models\Laboratorios $model */
/** @var yii\widgets\ActiveForm $form */

$usuarios = ArrayHelper::map(
    Usuarios::find()->all(),
    'id',
    'nombre'
);
?>

<div class="laboratorios-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ubicacion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'descripcion')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'responsable_id')->dropDownList(
        $usuarios,
        ['prompt' => 'Seleccione un responsable']
    ) ?>

    <?= $form->field($model, 'capacidad')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>