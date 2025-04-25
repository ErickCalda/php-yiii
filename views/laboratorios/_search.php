<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\LaboratoriosSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="laboratorios-search">

    <h3><?= Yii::t('app', 'Search Laboratorios') ?></h3>

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'id') ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'nombre') ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'ubicacion') ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'descripcion') ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'responsable_id') ?>
        </div>
        <!-- Commented to keep it clean
        <div class="col-md-4">
            <?= $form->field($model, 'capacidad') ?>
        </div> 
        -->
    </div>

    <div class="form-group mt-3">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary btn-block']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary btn-block']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<!-- Estilos CSS -->
<style>
    .laboratorios-search {
        background-color: #ffffff;
        border-radius: 8px;
        padding: 30px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .laboratorios-search h3 {
        font-weight: bold;
        color: #2c3e50;
    }

    .form-group {
        margin-top: 20px;
    }

    .form-control {
        border-radius: 5px;
        border: 1px solid #ddd;
    }

    .form-control:focus {
        box-shadow: 0 0 5px rgba(41, 128, 185, 0.6);
        border-color: #2980b9;
    }

    .btn-primary, .btn-outline-secondary {
        border-radius: 5px;
        font-weight: bold;
    }

    .btn-primary {
        background-color: #3498db;
        color: white;
    }

    .btn-primary:hover {
        background-color: #2980b9;
    }

    .btn-outline-secondary {
        color: #7f8c8d;
        border: 1px solid #7f8c8d;
    }

    .btn-outline-secondary:hover {
        background-color: #f4f4f4;
        border-color: #3498db;
        color: #3498db;
    }

    .row .col-md-4 {
        margin-bottom: 15px;
    }
</style>
