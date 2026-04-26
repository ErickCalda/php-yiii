<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

use app\models\Laboratorios;
use app\models\CatTiposEvento;
use app\models\CatEstadosBitacora;
use app\models\Reservas;
?>

<div class="bitacoras-form">

<?php $form = ActiveForm::begin([
    'id' => 'bitacoraForm',
    'options' => ['autocomplete' => 'off']
]); ?>

<!-- 🔹 RESERVA (FILTRADA POR USUARIO LOGUEADO) -->
<?= $form->field($model, 'reserva_id')->dropDownList(
    ArrayHelper::map(
        Reservas::find()
            ->where(['usuario_id' => Yii::$app->user->id])
            ->orderBy(['id' => SORT_DESC])
            ->all(),
        'id',
        function ($r) {
            return 'Reserva #' . $r->id .
                ' - ' . ($r->laboratorio->nombre ?? 'Sin lab') .
                ' - ' . $r->fecha;
        }
    ),
    [
        'prompt' => 'Selecciona tu reserva',
        'class' => 'form-control'
    ]
) ?>

<!-- 🔹 LABORATORIO -->
<?= $form->field($model, 'laboratorio_id')->dropDownList(
    ArrayHelper::map(
        Laboratorios::find()->all(),
        'id',
        'nombre'
    ),
    [
        'prompt' => 'Selecciona laboratorio',
        'class' => 'form-control'
    ]
) ?>

<!-- 🔹 TIPO DE EVENTO -->
<?= $form->field($model, 'tipo_evento_id')->dropDownList(
    ArrayHelper::map(
        CatTiposEvento::find()->all(),
        'id',
        'nombre'
    ),
    [
        'prompt' => 'Tipo de evento',
        'class' => 'form-control'
    ]
) ?>

<!-- 🔹 ESTADO -->
<?= $form->field($model, 'estado_id')->dropDownList(
    ArrayHelper::map(
        CatEstadosBitacora::find()->all(),
        'id',
        'nombre'
    ),
    [
        'prompt' => 'Estado',
        'class' => 'form-control'
    ]
) ?>

<!-- 🔹 TÍTULO -->
<?= $form->field($model, 'titulo')->textInput([
    'maxlength' => true,
    'class' => 'form-control',
    'placeholder' => 'Título del evento'
]) ?>

<!-- 🔹 DESCRIPCIÓN -->
<?= $form->field($model, 'descripcion')->textarea([
    'rows' => 5,
    'class' => 'form-control',
    'placeholder' => 'Describe lo ocurrido...'
]) ?>

<!-- 🔹 FECHA DEL EVENTO -->
<?= $form->field($model, 'fecha_evento')->input('datetime-local', [
    'class' => 'form-control'
]) ?>

<div class="form-actions">

    <?= Html::submitButton('Guardar', [
        'class' => 'btn-save'
    ]) ?>

</div>

<?php ActiveForm::end(); ?>

</div>