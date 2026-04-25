<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Laboratorios;

/** @var yii\web\View $this */
/** @var app\models\Equipos $model */
/** @var yii\widgets\ActiveForm $form */

$laboratorios = ArrayHelper::map(
    Laboratorios::find()
        ->orderBy(['nombre' => SORT_ASC])
        ->all(),
    'id',
    'nombre'
);
?>

<div class="equipos-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombre')->textInput([
        'maxlength' => true
    ]) ?>

    <?= $form->field($model, 'codigo_interno')->textInput([
        'maxlength' => true
    ]) ?>

    <?= $form->field($model, 'descripcion')->textarea([
        'rows' => 4
    ]) ?>

    <?= $form->field($model, 'estado')->dropDownList([
        'disponible' => 'Disponible',
        'en uso' => 'En uso',
        'en mantenimiento' => 'En mantenimiento',
        'dado de baja' => 'Dado de baja',
    ], [
        'prompt' => 'Seleccione estado'
    ]) ?>

    <?= $form->field($model, 'laboratorio_id')->dropDownList(
        $laboratorios,
        ['prompt' => 'Seleccione laboratorio']
    ) ?>

    <div class="form-group mt-3">
        <?= Html::submitButton(Yii::t('app', 'Guardar'), [
            'class' => 'btn btn-success'
        ]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>