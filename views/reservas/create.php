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

$this->registerCss(<<<CSS
    .reservas-form {
        background: #f8f9fa;
        border-radius: 1rem;
        padding: 2rem;
        max-width: 600px;
        margin: 2rem auto;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    }

    .reservas-form .form-control,
    .reservas-form .form-select {
        border-radius: 0.5rem;
        box-shadow: none;
        transition: all 0.2s;
    }

    .reservas-form .form-control:focus,
    .reservas-form .form-select:focus {
        border-color: #86b7fe;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
    }

    .reservas-form .form-group {
        margin-top: 1.5rem;
    }

    .reservas-form button {
        border-radius: 0.5rem;
        padding: 0.6rem 1.2rem;
    }

    /* Estilos adicionales */
    .btn-success {
        background-color: #28a745;
        border-color: #28a745;
        color: white;
        transition: background-color 0.3s, border-color 0.3s;
    }

    .btn-success:hover {
        background-color: #218838;
        border-color: #1e7e34;
    }
CSS);

$this->registerJsFile('https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.9.0/dist/js/bootstrap-datepicker.min.js', ['depends' => [\yii\web\JqueryAsset::class]]);
$this->registerCssFile('https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.9.0/dist/css/bootstrap-datepicker.min.css');

$this->registerJs(<<<JS
    $('#fecha-datepicker').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true
    });
JS);
?>

<div class="reservas-form">

    <?php $form = ActiveForm::begin([
        'options' => ['class' => 'needs-validation']
    ]); ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'laboratorio_id')->dropDownList(
                ArrayHelper::map(Laboratorios::find()->all(), 'id', 'nombre'),
                ['prompt' => 'Seleccionar laboratorio', 'class' => 'form-select']
            )->label('Laboratorio') ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'usuario_id')->dropDownList(
                ArrayHelper::map(Usuarios::find()->all(), 'id', 'nombre'),
                ['prompt' => 'Seleccionar usuario', 'class' => 'form-select']
            )->label('Usuario') ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'hora_inicio')->input('time', ['class' => 'form-control'])->label('Hora de inicio') ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'hora_fin')->input('time', ['class' => 'form-control'])->label('Hora de fin') ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'estado')->dropDownList(
                Reservas::optsEstado(),
                ['prompt' => 'Seleccionar estado', 'class' => 'form-select']
            )->label('Estado') ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'fecha')->textInput([
                'type' => 'text',
                'class' => 'form-control',
                'id' => 'fecha-datepicker',
                'placeholder' => 'YYYY-MM-DD',
                'value' => $model->fecha ? Yii::$app->formatter->asDate($model->fecha, 'php:Y-m-d') : ''
            ])->label('Fecha') ?>
        </div>
    </div>

    <div class="form-group text-end mt-4">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success shadow-sm']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
