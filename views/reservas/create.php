<?php
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use app\models\Usuarios;
use app\models\Laboratorios;
use app\models\Reservas;


/* @var $this yii\web\View */
/* @var $model app\models\Reservas */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="reservas-form">

    <?php $form = ActiveForm::begin(); ?>

    <!-- Campo para seleccionar el laboratorio -->
    <?= $form->field($model, 'laboratorio_id')->dropDownList(
        ArrayHelper::map(Laboratorios::find()->all(), 'id', 'nombre'),
        ['prompt' => 'Seleccionar laboratorio']
    )->label('Laboratorio') ?>

    <!-- Campo para seleccionar un usuario existente -->
    <?= $form->field($model, 'usuario_id')->dropDownList(
        ArrayHelper::map(Usuarios::find()->all(), 'id', 'nombre'),
        ['prompt' => 'Seleccionar usuario']
    )->label('Usuario') ?>

    <!-- Campo de hora de inicio -->
    <?= $form->field($model, 'hora_inicio')->input('time')->label('Hora de inicio') ?>

    <!-- Campo de hora de fin -->
    <?= $form->field($model, 'hora_fin')->input('time')->label('Hora de fin') ?>

    <!-- Campo para seleccionar el estado -->
    <?= $form->field($model, 'estado')->dropDownList(
        Reservas::optsEstado(), // Esto obtiene los valores posibles de estado (pendiente, aprobada, cancelada)
        ['prompt' => 'Seleccionar estado']
    )->label('Estado') ?>

    <!-- Campo para la fecha -->
    <?= $form->field($model, 'fecha')->input('date')->label('Fecha') ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
