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





```css id="t4v9zn"
/* ==========================================
   EJECUTIVA01 — FORM PREMIUM
   Microdetalles + Elegancia corporativa
========================================== */

:root{

    --exec-bg:#eef3f8;

    --exec-surface:#ffffff;

    --exec-border:#ccd6e2;

    --exec-border-soft:#dde6ef;

    --exec-text:#1e293b;

    --exec-soft:#64748b;

    --exec-primary:#23476b;

    --exec-primary2:#2f5f91;

    --exec-accent:#2563eb;

    --exec-danger:#b91c1c;

    --exec-radius:5px;
}


/* =========================
   CARD
========================= */

.lab-form-card{

    position:relative;

    overflow:hidden;

    background:
        linear-gradient(
            to bottom,
            #ffffff,
            #fbfdff
        );

    border:1px solid var(--exec-border);

    border-radius:var(--exec-radius);

    padding:32px;

    box-shadow:
        0 1px 2px rgba(15,23,42,.04),
        0 12px 30px rgba(15,23,42,.04);

    animation:fadeUp .35s ease;
}

/* línea premium superior */
.lab-form-card::before{

    content:"";

    position:absolute;

    top:0;
    left:0;

    width:100%;
    height:1px;

    background:
        linear-gradient(
            90deg,
            transparent,
            rgba(255,255,255,.95),
            transparent
        );
}

/* glow lateral elegante */
.lab-form-card::after{

    content:"";

    position:absolute;

    top:0;
    left:-140px;

    width:240px;
    height:100%;

    background:
        linear-gradient(
            90deg,
            transparent,
            rgba(255,255,255,.05),
            transparent
        );

    transform:skewX(-18deg);

    pointer-events:none;
}


/* =========================
   GRID
========================= */

.form-grid{

    display:grid;

    grid-template-columns:repeat(12,1fr);

    gap:18px;
}

.col-12{grid-column:span 12;}
.col-6{grid-column:span 6;}
.col-4{grid-column:span 4;}


/* =========================
   LABELS
========================= */

.field-label{

    display:flex;

    align-items:center;

    gap:8px;

    margin-bottom:9px;

    color:var(--exec-text);

    font-size:12px;

    font-weight:700;

    text-transform:uppercase;

    letter-spacing:.5px;
}


/* mini accent */
.field-label::before{

    content:"";

    width:8px;
    height:8px;

    background:#2563eb;

    border-radius:2px;

    opacity:.75;
}


/* =========================
   INPUTS
========================= */

.modern-input{

    width:100%;

    height:44px;

    padding:0 14px!important;

    background:
        linear-gradient(
            to bottom,
            #ffffff,
            #fbfdff
        )!important;

    border:1px solid var(--exec-border)!important;

    border-radius:4px!important;

    color:var(--exec-text)!important;

    font-size:14px!important;

    font-weight:500;

    box-shadow:none!important;

    outline:none!important;

    transition:
        border-color .16s ease,
        background .16s ease,
        box-shadow .16s ease,
        transform .16s ease!important;
}


/* hover sutil */
.modern-input:hover{

    border-color:#b7c7d8!important;

    background:#fff!important;
}


/* focus premium */
.modern-input:focus{

    border-color:#2563eb!important;

    background:#fff!important;

    box-shadow:
        0 0 0 3px rgba(37,99,235,.10),
        inset 0 1px 0 rgba(255,255,255,.85)!important;

    transform:translateY(-1px);
}


/* placeholder elegante */
.modern-input::placeholder{

    color:#94a3b8;

    font-weight:500;
}


/* =========================
   SELECTS
========================= */

select.modern-input{

    appearance:none;

    background-image:
        linear-gradient(45deg, transparent 50%, #64748b 50%),
        linear-gradient(135deg, #64748b 50%, transparent 50%);

    background-position:
        calc(100% - 18px) 18px,
        calc(100% - 13px) 18px;

    background-size:5px 5px;

    background-repeat:no-repeat;

    padding-right:40px!important;
}


/* =========================
   TEXTAREA
========================= */

.modern-textarea{

    min-height:150px;

    resize:vertical;

    padding:14px!important;

    line-height:1.7;
}


/* =========================
   ERRORS
========================= */

.field-error{

    margin-top:7px;

    color:var(--exec-danger);

    font-size:12px;

    font-weight:600;
}


/* =========================
   ACTIONS
========================= */

.form-actions{

    display:flex;

    justify-content:flex-end;

    gap:12px;

    margin-top:28px;

    padding-top:22px;

    border-top:1px solid #e8eef5;

    flex-wrap:wrap;
}


/* =========================
   BUTTONS
========================= */

.btn-cancel,
.btn-save{

    position:relative;

    overflow:hidden;

    height:42px;

    padding:0 18px;

    display:inline-flex;

    align-items:center;

    justify-content:center;

    border-radius:4px;

    text-decoration:none;

    font-size:13px;

    font-weight:700;

    transition:
        background .16s ease,
        border-color .16s ease,
        transform .16s ease,
        box-shadow .16s ease;
}


/* brillo interno */
.btn-cancel::before,
.btn-save::before{

    content:"";

    position:absolute;

    inset:0;

    background:
        linear-gradient(
            to bottom,
            rgba(255,255,255,.18),
            transparent
        );

    pointer-events:none;
}


/* cancel */

.btn-cancel{

    background:
        linear-gradient(
            to bottom,
            #ffffff,
            #f2f6fa
        );

    border:1px solid #ccd6e2;

    color:#334155;
}

.btn-cancel:hover{

    background:
        linear-gradient(
            to bottom,
            #ffffff,
            #edf3f8
        );

    border-color:#b8c8d8;

    transform:translateY(-1px);

    box-shadow:
        0 6px 12px rgba(15,23,42,.04);
}


/* save */

.btn-save{

    border:1px solid #2d5682;

    color:#fff;

    background:
        linear-gradient(
            to bottom,
            #296eb7,
            #24476f
        );

   
}

.btn-save:hover{

    background:
        linear-gradient(
            to bottom,
            #3f73ad,
            #29527f
        );

    transform:translateY(-1px);

    box-shadow:
        0 14px 24px rgba(37,99,235,.16);
}


/* =========================
   INPUT GROUP EFFECT
========================= */

.form-group{

    position:relative;
}

/* línea glow focus */
.form-group:focus-within .field-label{

    color:#1d4ed8;
}


/* =========================
   ANIMATIONS
========================= */

@keyframes fadeUp{

    from{

        opacity:0;

        transform:translateY(10px);
    }

    to{

        opacity:1;

        transform:translateY(0);
    }
}


/* =========================
   SCROLLBAR
========================= */

::-webkit-scrollbar{

    width:10px;
}

::-webkit-scrollbar-track{

    background:#edf2f7;
}

::-webkit-scrollbar-thumb{

    background:#bcc9d8;

    border:2px solid #edf2f7;

    border-radius:20px;
}

::-webkit-scrollbar-thumb:hover{

    background:#9fb1c5;
}


/* =========================
   MOBILE
========================= */

@media(max-width:900px){

    .col-6,
    .col-4,
    .col-12{

        grid-column:span 12;
    }

    .lab-form-card{

        padding:20px;
    }
}

@media(max-width:640px){

    .form-actions{

        flex-direction:column;
    }

    .btn-save,
    .btn-cancel{

        width:100%;
    }
}









</style>