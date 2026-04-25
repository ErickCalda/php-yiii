<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Usuarios;
use app\models\Laboratorios;

/** @var yii\web\View $this */
/** @var app\models\Reservas $model */
/** @var yii\widgets\ActiveForm $form */

/*
|--------------------------------------------------------------------------
| Laboratorios
|--------------------------------------------------------------------------
*/
$laboratorios = ArrayHelper::map(
    Laboratorios::find()
        ->orderBy(['nombre' => SORT_ASC])
        ->all(),
    'id',
    'nombre'
);

/*
|--------------------------------------------------------------------------
| Usuarios activos EXCEPTO admin
|--------------------------------------------------------------------------
| admin = rol_id 1
*/
$usuariosQuery = Usuarios::find()
    ->where(['estado' => 'activo'])
    ->andWhere(['<>', 'rol_id', 1])
    ->orderBy(['nombre' => SORT_ASC])
    ->all();

$usuarios = ArrayHelper::map(
    $usuariosQuery,
    'id',
    function ($usuario) {
        return $usuario->nombre . ' ' . $usuario->apellido;
    }
);

$sinUsuarios = empty($usuarios);

?>

<div class="reservas-form">

    <?php if ($model->hasErrors()): ?>
        <div class="alert alert-danger">
            <strong>Atención:</strong> Corrige los errores del formulario.
        </div>
    <?php endif; ?>

    <?php if ($sinUsuarios): ?>
        <div class="alert alert-warning">
            No hay usuarios disponibles para reservar.
        </div>
    <?php endif; ?>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'laboratorio_id')->dropDownList(
        $laboratorios,
        ['prompt' => 'Seleccione laboratorio']
    ) ?>

    <?= $form->field($model, 'usuario_id')->dropDownList(
        $usuarios,
        [
            'prompt' => $sinUsuarios
                ? 'No hay usuarios disponibles'
                : 'Seleccione usuario',
            'disabled' => $sinUsuarios
        ]
    ) ?>

    <?= $form->field($model, 'fecha')->input('date') ?>

    <?= $form->field($model, 'hora_inicio')->input('time') ?>

    <?= $form->field($model, 'hora_fin')->input('time') ?>

    <?= $form->field($model, 'estado')->dropDownList(
        [
            'pendiente' => 'Pendiente',
            'aprobada'  => 'Aprobada',
            'rechazada' => 'Rechazada'
        ],
        ['prompt' => 'Seleccionar estado']
    ) ?>

    <div class="form-group mt-3">
        <?= Html::submitButton('Guardar', [
            'class' => 'btn btn-success',
            'disabled' => $sinUsuarios
        ]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>