<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Materiales $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="materiales-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'unidad_medida')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cantidad')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'laboratorio_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

/* ===============================
   PALETA ELEGIDA
   Slate + Indigo + White
=================================*/
:root{
    --bg:#F8FAFC;
    --surface:#FFFFFF;
    --text:#0F172A;
    --text-soft:#64748B;
    --line:#E2E8F0;
    --primary:#6366F1;
    --primary-hover:#4F46E5;
    --hover:#F8FAFC;
    --danger:#EF4444;
}

/* CONTENEDOR */
.materiales-form{
    max-width:760px;
    background:var(--surface);
    border:1px solid var(--line);
    border-radius:26px;
    padding:34px;
    box-shadow:0 10px 30px rgba(15,23,42,.04);
}

/* GRUPOS */
.form-group,
.mb-3{
    margin-bottom:22px;
}

/* LABELS */
.control-label,
.form-label{
    display:block;
    font-size:13px;
    font-weight:700;
    letter-spacing:.02em;
    color:var(--text-soft);
    margin-bottom:10px;
}

/* INPUTS */
.form-control{
    width:100%;
    height:52px;
    border:1px solid var(--line);
    background:white;
    border-radius:16px;
    padding:0 16px;
    font-size:15px;
    color:var(--text);
    box-shadow:none !important;
    transition:.18s ease;
}

.form-control::placeholder{
    color:#94A3B8;
}

.form-control:hover{
    border-color:#CBD5E1;
}

.form-control:focus{
    outline:none;
    border-color:var(--primary);
    box-shadow:0 0 0 4px rgba(99,102,241,.10) !important;
}

/* BOTON */
.btn-success{
    all:unset;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    padding:12px 20px;
    min-width:130px;
    background:var(--primary);
    color:white;
    border-radius:999px;
    font-size:14px;
    font-weight:600;
    cursor:pointer;
    transition:.18s ease;
}

.btn-success:hover{
    background:var(--primary-hover);
    transform:translateY(-1px);
}

/* ERROR */
.help-block,
.invalid-feedback{
    font-size:13px;
    color:var(--danger);
    margin-top:8px;
}

.has-error .form-control,
.is-invalid{
    border-color:var(--danger);
}

.has-error .form-control:focus,
.is-invalid:focus{
    box-shadow:0 0 0 4px rgba(239,68,68,.08) !important;
}

/* TEXTO AYUDA */
.help-block-hint{
    font-size:13px;
    color:var(--text-soft);
    margin-top:8px;
}

/* RESPONSIVE */
@media(max-width:768px){

.materiales-form{
    padding:22px;
    border-radius:20px;
}

.form-control{
    height:48px;
    font-size:14px;
}

.btn-success{
    width:100%;
}

}
</style>