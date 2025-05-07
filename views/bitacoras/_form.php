<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Bitacoras $model */
/** @var yii\widgets\ActiveForm $form */
/** @var app\models\Reservas $model */
?>

<div class="bitacoras-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'reserva_id')->dropDownList(
    \yii\helpers\ArrayHelper::map(
        \app\models\Reservas::find()
            ->select(['usuario_id'])      // Solo ID del usuario
            ->distinct()                  // Solo valores únicos
            ->with('usuario')             // Relación para traer el nombre
            ->all(),
        'usuario_id',                    // Este será el valor del <option>
        function ($reserva) {
            return $reserva->usuario->nombre ?? 'Sin nombre';
        }
    ),
    ['prompt' => 'Selecciona una persona que reservó']
) ?>



    <?= $form->field($model, 'descripcion')->textarea(['rows' => 6]) ?>

    <?php //  $form->field($model, 'archivo_adjunto')->textInput(['maxlength' => true]); ?>

    <?= $form->field($model, 'fecha_registro')->widget(\yii\jui\DatePicker::class, [
    'language' => 'es',
    'dateFormat' => 'yyyy-MM-dd',
    'options' => ['class' => 'form-control'],
]) ?>


    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
