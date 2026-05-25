<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

use app\models\Laboratorios;
use app\models\CatTiposEvento;
use app\models\CatEstadosBitacora;
use app\models\ClasesProgramadas;

?>

<div class="bitacoras-form">

<?php $form = ActiveForm::begin([
    'id' => 'bitacora-form',
    'options' => [
        'autocomplete' => 'off'
    ]
]); ?>

<!-- CLASE PROGRAMADA (OPCIONAL) -->
<?= $form->field($model, 'clase_programada_id')->dropDownList(

    ArrayHelper::map(

        ClasesProgramadas::find()
            ->with(['laboratorio', 'materia', 'curso'])
            ->orderBy([
                'dia_semana' => SORT_ASC,
                'hora_inicio' => SORT_ASC
            ])
            ->all(),

        'id',

        function ($c) {

            return ucfirst($c->dia_semana)
                . ' | '
                . substr($c->hora_inicio, 0, 5)
                . ' - '
                . substr($c->hora_fin, 0, 5)
                . ' | '
                . ($c->laboratorio->nombre ?? 'Sin Lab')
                . ' | '
                . ($c->materia->nombre ?? 'Sin Materia')
                . ' | '
                . ($c->curso->nombre ?? 'Sin Curso');
        }
    ),

    [
        'prompt' => 'Sin relación con clase (opcional)',
        'class' => 'form-control'
    ]
) ?>

<!-- LABORATORIO -->
<?= $form->field($model, 'laboratorio_id')->dropDownList(

    ArrayHelper::map(
        Laboratorios::find()
            ->orderBy('nombre')
            ->all(),

        'id',
        'nombre'
    ),

    [
        'prompt' => 'Selecciona laboratorio',
        'class' => 'form-control'
    ]
) ?>

<!-- TIPO DE EVENTO -->
<?= $form->field($model, 'tipo_evento_id')->dropDownList(

    ArrayHelper::map(
        CatTiposEvento::find()
            ->orderBy('nombre')
            ->all(),

        'id',
        'nombre'
    ),

    [
        'prompt' => 'Selecciona tipo de evento',
        'class' => 'form-control'
    ]
) ?>

<!-- ESTADO -->
<?= $form->field($model, 'estado_id')->dropDownList(

    ArrayHelper::map(
        CatEstadosBitacora::find()
            ->orderBy('nombre')
            ->all(),

        'id',
        'nombre'
    ),

    [
        'prompt' => 'Selecciona estado',
        'class' => 'form-control'
    ]
) ?>

<!-- TITULO -->
<?= $form->field($model, 'titulo')->textInput([
    'maxlength' => true,
    'class' => 'form-control',
    'placeholder' => 'Ej: Equipo dañado, Clase suspendida...'
]) ?>

<!-- DESCRIPCION -->
<?= $form->field($model, 'descripcion')->textarea([
    'rows' => 5,
    'class' => 'form-control',
    'placeholder' => 'Describe detalladamente lo ocurrido...'
]) ?>

<!-- FECHA EVENTO -->
<?= $form->field($model, 'fecha_evento')->input('datetime-local', [
    'class' => 'form-control'
]) ?>

<div class="form-actions">

 <?= Html::submitButton('Guardar Bitácora', [
    'class' => 'btn-save',
    'data-disable-with' => 'Guardando...'
]) ?>

</div>


<?php ActiveForm::end(); ?>

</div>