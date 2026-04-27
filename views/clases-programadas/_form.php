<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

use app\models\Laboratorios;
use app\models\Usuarios;
use app\models\Materias;
use app\models\Cursos;
use app\models\PeriodosAcademicos;

/** @var yii\web\View $this */
/** @var app\models\ClasesProgramadas $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="clases-programadas-form">

<?php $form = ActiveForm::begin([
    'options' => ['autocomplete' => 'off']
]); ?>

<!-- 🔹 LABORATORIO -->
<?= $form->field($model, 'laboratorio_id')->dropDownList(
    ArrayHelper::map(
        Laboratorios::find()->orderBy('nombre')->all(),
        'id',
        'nombre'
    ),
    ['prompt' => 'Seleccione laboratorio']
) ?>

<!-- 🔹 DOCENTE -->
<?= $form->field($model, 'docente_id')->dropDownList(
    ArrayHelper::map(
        Usuarios::find()->where(['rol_id' => \app\models\Usuarios::ROL_DOCENTE])->all(),
        'id',
        fn($u) => $u->nombre . ' ' . $u->apellido
    ),
    ['prompt' => 'Seleccione docente']
) ?>

<!-- 🔹 MATERIA -->
<?= $form->field($model, 'materia_id')->dropDownList(
    ArrayHelper::map(
        Materias::find()->orderBy('nombre')->all(),
        'id',
        'nombre'
    ),
    ['prompt' => 'Seleccione materia']
) ?>

<!-- 🔹 CURSO -->
<?= $form->field($model, 'curso_id')->dropDownList(
    ArrayHelper::map(
        Cursos::find()->orderBy('nombre')->all(),
        'id',
        'nombre'
    ),
    ['prompt' => 'Seleccione curso']
) ?>

<!-- 🔹 PERÍODO -->
<?= $form->field($model, 'periodo_id')->dropDownList(
    ArrayHelper::map(
        PeriodosAcademicos::find()->where(['activo' => 1])->all(),
        'id',
        'nombre'
    ),
    ['prompt' => 'Seleccione período']
) ?>

<!-- 🔹 DÍA -->
<?= $form->field($model, 'dia_semana')->dropDownList([
    'lunes' => 'Lunes',
    'martes' => 'Martes',
    'miercoles' => 'Miércoles',
    'jueves' => 'Jueves',
    'viernes' => 'Viernes',
], ['prompt' => 'Seleccione día']) ?>

<!-- 🔹 HORAS -->
<?= $form->field($model, 'hora_inicio')->input('time') ?>
<?= $form->field($model, 'hora_fin')->input('time') ?>

<!-- 🔹 ESTADO -->
<?= $form->field($model, 'estado')->dropDownList([
    1 => 'Activo',
    0 => 'Inactivo'
]) ?>

<div class="form-group mt-3">
    <?= Html::submitButton('Guardar clase', [
        'class' => 'btn btn-success'
    ]) ?>
</div>

<?php ActiveForm::end(); ?>

</div>