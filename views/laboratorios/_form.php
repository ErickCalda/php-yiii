<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Laboratorios $model */
/** @var yii\widgets\ActiveForm $form */
/** @var array $tipos */
/** @var array $estados */
/** @var array $ubicaciones */
/** @var array $responsables */
?>

<div class="lab-form-card">

<?php $form = ActiveForm::begin([
    'options' => ['class' => 'modern-form'],
    'fieldConfig' => [
        'template' => "{label}\n{input}\n{error}",
        'labelOptions' => ['class' => 'field-label'],
        'errorOptions' => ['class' => 'field-error'],
    ],
]); ?>

<div class="form-grid">

    <div class="col-12">
        <?= $form->field($model, 'responsable_id')->dropDownList(
            $responsables,
            [
                'prompt' => 'Seleccionar responsable del laboratorio',
                'class' => 'form-select modern-input'
            ]
        ) ?>
    </div>

    <div class="col-6">
        <?= $form->field($model, 'codigo')->textInput([
            'maxlength' => true,
            'placeholder' => 'Ej: LAB-INF-01',
            'class' => 'form-control modern-input'
        ]) ?>
    </div>

    <div class="col-6">
        <?= $form->field($model, 'nombre')->textInput([
            'maxlength' => true,
            'placeholder' => 'Nombre del laboratorio',
            'class' => 'form-control modern-input'
        ]) ?>
    </div>

    <div class="col-4">
        <?= $form->field($model, 'tipo_id')->dropDownList(
            $tipos,
            ['prompt' => 'Seleccionar tipo', 'class' => 'form-select modern-input']
        ) ?>
    </div>

    <div class="col-4">
        <?= $form->field($model, 'estado_id')->dropDownList(
            $estados,
            ['prompt' => 'Seleccionar estado', 'class' => 'form-select modern-input']
        ) ?>
    </div>

    <div class="col-4">
        <?= $form->field($model, 'capacidad')->input('number', [
            'min' => 1,
            'placeholder' => '0',
            'class' => 'form-control modern-input'
        ]) ?>
    </div>

    <div class="col-12">
        <?= $form->field($model, 'ubicacion_id')->dropDownList(
            $ubicaciones,
            ['prompt' => 'Seleccionar ubicación', 'class' => 'form-select modern-input']
        ) ?>
    </div>

    <div class="col-12">
        <?= $form->field($model, 'descripcion')->textarea([
            'rows' => 5,
            'placeholder' => 'Descripción general, equipos, observaciones...',
            'class' => 'form-control modern-input modern-textarea'
        ]) ?>
    </div>

</div>

<div class="form-actions">

    <?= Html::a('Cancelar', ['index'], ['class' => 'btn-cancel']) ?>

    <?= Html::submitButton(
        $model->isNewRecord ? 'Guardar Laboratorio' : 'Actualizar Laboratorio',
        ['class' => 'btn-save']
    ) ?>

</div>

<?php ActiveForm::end(); ?>

</div>

<style>
:root{
--bg:#F8FAFC;
--surface:#FFFFFF;
--text:#0F172A;
--muted:#64748B;
--line:#E2E8F0;
--primary:#6366F1;
--primary2:#4F46E5;
}

.lab-form-card{
background:rgba(255,255,255,.82);
backdrop-filter:blur(16px);
border:1px solid rgba(226,232,240,.9);
border-radius:28px;
padding:34px;
box-shadow:0 18px 40px rgba(15,23,42,.07);
animation:fadeUp .45s ease;
}

.form-grid{
display:grid;
grid-template-columns:repeat(12,1fr);
gap:18px;
}

.col-12{grid-column:span 12;}
.col-6{grid-column:span 6;}
.col-4{grid-column:span 4;}

.field-label{
display:block;
font-size:13px;
font-weight:700;
color:var(--text);
margin-bottom:8px;
letter-spacing:.01em;
}

.modern-input{
width:100%;
border:1px solid var(--line)!important;
border-radius:16px!important;
padding:13px 15px!important;
font-size:15px!important;
color:var(--text)!important;
background:#fff!important;
box-shadow:none!important;
transition:.18s ease!important;
}

.modern-input:focus{
border-color:var(--primary)!important;
box-shadow:0 0 0 4px rgba(99,102,241,.10)!important;
transform:translateY(-1px);
}

.modern-textarea{
resize:vertical;
min-height:140px;
}

.field-error{
margin-top:7px;
font-size:12px;
color:#DC2626;
font-weight:600;
}

.form-actions{
display:flex;
justify-content:flex-end;
gap:14px;
margin-top:28px;
flex-wrap:wrap;
}

.btn-cancel{
padding:12px 18px;
border-radius:16px;
text-decoration:none;
font-weight:600;
color:var(--text);
background:#fff;
border:1px solid var(--line);
transition:.18s ease;
}

.btn-cancel:hover{
background:#F1F5F9;
color:var(--text);
}

.btn-save{
border:none;
padding:12px 20px;
border-radius:16px;
font-weight:700;
color:#fff;
background:linear-gradient(135deg,var(--primary),var(--primary2));
box-shadow:0 12px 26px rgba(99,102,241,.22);
transition:.18s ease;
}

.btn-save:hover{
transform:translateY(-2px) scale(1.01);
}

@keyframes fadeUp{
from{
opacity:0;
transform:translateY(14px);
}
to{
opacity:1;
transform:translateY(0);
}
}

@media(max-width:900px){
.col-6,.col-4,.col-12{
grid-column:span 12;
}
.lab-form-card{
padding:20px;
border-radius:22px;
}
}
</style>