<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Laboratorios $model */

$this->title = Yii::t('app', 'Update Laboratorios: {name}', [
    'name' => $model->id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Laboratorios'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="laboratorios-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="card shadow-sm">
        <div class="card-body">
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>

</div>

<!-- Estilos CSS -->
<style>
    .laboratorios-update {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f4f4f4;
        padding: 30px;
        border-radius: 8px;
    }

    h1 {
        color: #2c3e50;
        font-weight: bold;
    }

    .card {
        background-color: #ffffff;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        margin-top: 20px;
    }

    .card-header {
        background-color: #2c3e50;
        color: white;
        font-weight: bold;
        padding: 15px;
    }

    .card-body {
        padding: 20px;
    }

    .btn-success {
        background-color: #3498db;
        color: white;
        border-radius: 5px;
        font-weight: bold;
    }

    .btn-success:hover {
        background-color: #2980b9;
    }

    .form-control {
        border-radius: 5px;
        border: 1px solid #ddd;
    }

    .form-control:focus {
        box-shadow: 0 0 5px rgba(41, 128, 185, 0.6);
        border-color: #2980b9;
    }

    .breadcrumb {
        background-color: transparent;
        padding: 10px 0;
        margin-bottom: 20px;
    }

    .breadcrumb a {
        color: #2980b9;
        text-decoration: none;
        font-weight: bold;
    }

    .breadcrumb a:hover {
        text-decoration: underline;
    }
</style>
