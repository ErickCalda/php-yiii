<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Laboratorios $model */

$this->title = Yii::t('app', 'Create Laboratorios');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Laboratorios'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="laboratorios-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="card custom-card">
        <div class="card-body">
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>

</div>

<!-- Estilos CSS -->
<style>
    .laboratorios-create {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #e9ecef;
        padding: 40px 20px;
        border-radius: 12px;
        max-width: 900px;
        margin: 0 auto;
    }

    h1 {
        color: #34495e;
        font-weight: bold;
        margin-bottom: 30px;
        text-align: center;
    }

    .custom-card {
        background-color: #ffffff;
        border-radius: 15px;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        border: none;
        transition: transform 0.2s ease, box-shadow 0.3s ease;
    }

    .custom-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 30px rgba(0, 0, 0, 0.15);
    }

    .card-body {
        padding: 25px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-control {
        border-radius: 8px;
        border: 1px solid #ddd;
        padding: 15px;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        box-shadow: 0 0 10px rgba(41, 128, 185, 0.7);
        border-color: #3498db;
    }

    .btn-success {
        background-color: #3498db;
        border-radius: 8px;
        padding: 12px 30px;
        color: white;
        font-weight: bold;
        transition: background-color 0.3s ease, transform 0.3s ease;
    }

    .btn-success:hover {
        background-color: #2980b9;
        transform: translateY(-3px);
    }

    .breadcrumb {
        background-color: transparent;
        padding: 10px 0;
        margin-bottom: 20px;
        font-size: 14px;
    }

    .breadcrumb a {
        color: #3498db;
        text-decoration: none;
        font-weight: bold;
    }

    .breadcrumb a:hover {
        text-decoration: underline;
    }

    .form-group label {
        font-weight: bold;
        color: #2c3e50;
        margin-bottom: 5px;
    }
</style>
