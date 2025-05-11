<?php
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use app\models\Usuarios;
use app\models\Laboratorios;
use app\models\Reservas;

$this->registerCss(<<<CSS
    .reservas-form {
        background: #ffffff;
        border-radius: 15px;
        padding: 30px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        max-width: 700px;
        margin: 0 auto;
    }
    .reservas-form .form-group {
        margin-bottom: 20px;
    }
    .reservas-form label {
        font-weight: 500;
        margin-bottom: 5px;
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

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'laboratorio_id')->dropDownList(
                ArrayHelper::map(Laboratorios::find()->all(), 'id', 'nombre'),
                ['prompt' => 'Seleccionar laboratorio']
            )->label('Laboratorio') ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'usuario_id')->dropDownList(
                ArrayHelper::map(Usuarios::find()->all(), 'id', 'nombre'),
                ['prompt' => 'Seleccionar usuario']
            )->label('Usuario') ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'hora_inicio')->input('time')->label('Hora de inicio') ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'hora_fin')->input('time')->label('Hora de fin') ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'estado')->dropDownList(
                Reservas::optsEstado(),
                ['prompt' => 'Seleccionar estado']
            )->label('Estado') ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'fecha')->textInput([
                'id' => 'fecha-datepicker',
                'placeholder' => 'YYYY-MM-DD'
            ])->label('Fecha') ?>
        </div>
    </div>

    <div class="form-group text-end mt-4">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
