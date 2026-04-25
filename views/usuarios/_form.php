<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Roles;

/** @var yii\web\View $this */
/** @var app\models\Usuarios $model */
/** @var yii\widgets\ActiveForm $form */

?>

<div class="usuarios-form card shadow-sm border-0 rounded-4 p-4" style="background:#FFFFFF;">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row g-4">

        <div class="col-md-6">
            <?= $form->field($model, 'nombre')->textInput([
                'maxlength' => true,
                'class' => 'form-control campo-apple'
            ]) ?>
        </div>

        <div class="col-md-6">
            <?= $form->field($model, 'apellido')->textInput([
                'maxlength' => true,
                'class' => 'form-control campo-apple'
            ]) ?>
        </div>

        <div class="col-md-6">
            <?= $form->field($model, 'correo')->textInput([
                'maxlength' => true,
                'class' => 'form-control campo-apple'
            ]) ?>
        </div>

        <div class="col-md-6">
            <?= $form->field($model, 'clave')->passwordInput([
                'maxlength' => true,
                'placeholder' => 'Ingrese contraseña',
                'class' => 'form-control campo-apple'
            ]) ?>
        </div>

        <div class="col-md-6">
            <?= $form->field($model, 'rol_id')->dropDownList(
                ArrayHelper::map(
                    Roles::find()->orderBy(['nombre' => SORT_ASC])->all(),
                    'id',
                    'nombre'
                ),
                [
                    'prompt' => 'Seleccione rol',
                    'class' => 'form-select campo-apple'
                ]
            ) ?>
        </div>

        <div class="col-md-6">
            <?= $form->field($model, 'estado')->dropDownList(
                [
                    'activo' => 'Activo',
                    'inactivo' => 'Inactivo',
                    'bloqueado' => 'Bloqueado',
                ],
                [
                    'class' => 'form-select campo-apple'
                ]
            ) ?>
        </div>

        <div class="col-md-6">
            <?= $form->field($model, 'fecha_creacion')->textInput([
                'readonly' => true,
                'value' => $model->fecha_creacion ?: date('Y-m-d H:i:s'),
                'class' => 'form-control campo-apple bg-light'
            ]) ?>
        </div>

        <div class="col-md-6">
            <?= $form->field($model, 'fecha_ultima_actualizacion')->textInput([
                'readonly' => true,
                'value' => $model->fecha_ultima_actualizacion ?: date('Y-m-d H:i:s'),
                'class' => 'form-control campo-apple bg-light'
            ]) ?>
        </div>

    </div>

    <div class="mt-4 d-flex gap-2">
        <?= Html::submitButton('Guardar Usuario', [
            'class' => 'btn text-white px-4 rounded-3',
            'style' => 'background:#6366F1; border:none;'
        ]) ?>

        <?= Html::a('Cancelar', ['index'], [
            'class' => 'btn px-4 rounded-3',
            'style' => 'background:#F8FAFC; color:#0F172A; border:1px solid #E2E8F0;'
        ]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<style>

.form-group {
    position: relative;
}

/* INPUT estilo Apple limpio */
.campo-apple {
    border: none !important;
    border-bottom: 1.5px solid rgba(99,102,241,0.25);
    border-radius: 0 !important;
    background: transparent;
    padding: 10px 0;
    box-shadow: none !important;
    outline: none !important;
    width: 100%;
    display: block;
}

.campo-apple {
    padding-bottom: 12px; /* deja espacio real para la línea */
}

/* ERROR Yii */
.help-block,
.invalid-feedback {
    font-size: 12px;
    color: #EF4444;
    margin-top: 4px;
    display: block;
}

/* 🔥 WRAPPER DE LINEA (ESTABLE DESDE PRIMER RENDER) */
.form-group {
    position: relative;
}

/* línea real (NO pseudo-elemento del form-group) */
.form-group::after {
    content: "";
    position: absolute;
    left: 0;
    bottom: 0; /* 🔥 clave */
    height: 2px;
    width: 0%;
    background: #6366F1;
    transition: width .3s ease-in-out;
    transform-origin: left;
}

/* animación estable */
.form-group:focus-within::after {
    width: 100%;
}

/* error no mueve layout */
.has-error .campo-apple {
    border-bottom-color: #EF4444 !important;
}

.has-error .form-group::after {
    background: #EF4444;
}

</style>