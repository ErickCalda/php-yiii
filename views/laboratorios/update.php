<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Laboratorios $model */
/** @var array $tipos */
/** @var array $estados */
/** @var array $ubicaciones */

$this->title = 'Editar Laboratorio';

$this->params['breadcrumbs'][] = [
    'label' => 'Laboratorios',
    'url'   => ['index']
];

$this->params['breadcrumbs'][] = [
    'label' => $model->nombre,
    'url'   => ['view', 'id' => $model->id]
];

$this->params['breadcrumbs'][] = $this->title;

$estadoNombre = $model->estado->nombre ?? 'Sin estado';
$responsableNombre = $model->responsable->nombre ?? 'Sin asignar';
?>

<div class="edit-page">

<!-- HERO -->
<section class="hero-box">

    <div class="hero-left">

        <div class="hero-top">

            <span class="hero-chip">
                Modo Edición
            </span>

            <span class="hero-id">
                #<?= $model->id ?>
            </span>

        </div>

        <h1><?= Html::encode($this->title) ?></h1>

        <p>
            Estás modificando la información del laboratorio
            <strong><?= Html::encode($model->nombre) ?></strong>.
            Realiza cambios seguros, rápidos y organizados.
        </p>

        <div class="hero-meta">

            <span>
                Código:
                <strong><?= Html::encode($model->codigo) ?></strong>
            </span>

            <span>
                Estado actual:
                <strong><?= Html::encode($estadoNombre) ?></strong>
            </span>

            <span>
                Responsable:
                <strong><?= Html::encode($responsableNombre) ?></strong>
            </span>

        </div>

    </div>

    <div class="hero-right">

        <?= Html::a(
            '← Volver',
            ['view', 'id' => $model->id],
            ['class' => 'btn-light']
        ) ?>

    </div>

</section>

<!-- FORM CARD -->
<section class="form-shell">

    <div class="shell-top">

        <div>
            <h2>Actualizar Información</h2>
            <p>
                Modifica los campos necesarios y guarda los cambios.
            </p>
        </div>

        <div class="top-status">
            En edición
        </div>

    </div>

    <div class="shell-body">

<?= $this->render('_form', [
    'model' => $model,
    'tipos' => $tipos,
    'estados' => $estados,
    'ubicaciones' => $ubicaciones,
    'responsables' => $responsables, // 🔥 AGREGAR ESTO
]) ?>

    </div>

</section>

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

/* PAGE */
.edit-page{
max-width:1180px;
margin:auto;
padding:22px;
animation:fadeUp .45s ease;
}

/* HERO */
.hero-box{
display:grid;
grid-template-columns:1fr auto;
gap:20px;
padding:30px;
margin-bottom:18px;
border-radius:30px;
background:rgba(255,255,255,.82);
backdrop-filter:blur(18px);
border:1px solid rgba(255,255,255,.85);
box-shadow:0 24px 48px rgba(15,23,42,.05);
}

.hero-top{
display:flex;
gap:10px;
flex-wrap:wrap;
margin-bottom:14px;
}

.hero-chip,
.hero-id{
padding:7px 12px;
border-radius:999px;
font-size:12px;
font-weight:800;
}

.hero-chip{
background:#EEF2FF;
color:var(--primary);
}

.hero-id{
background:#F1F5F9;
color:var(--text);
}

.hero-box h1{
margin:0;
font-size:clamp(30px,6vw,44px);
font-weight:900;
letter-spacing:-1.2px;
color:var(--text);
}

.hero-box p{
margin:10px 0 0;
max-width:700px;
line-height:1.65;
color:var(--muted);
font-size:15px;
}

.hero-meta{
display:flex;
gap:14px;
flex-wrap:wrap;
margin-top:16px;
}

.hero-meta span{
padding:10px 14px;
border-radius:16px;
background:#F8FAFC;
border:1px solid var(--line);
font-size:13px;
font-weight:700;
color:var(--muted);
}

.hero-meta strong{
color:var(--text);
}

.hero-right{
display:flex;
align-items:flex-start;
}

/* BUTTON */
.btn-light{
height:48px;
padding:0 18px;
display:inline-flex;
align-items:center;
justify-content:center;
border-radius:16px;
text-decoration:none;
font-weight:800;
background:#fff;
border:1px solid var(--line);
color:var(--text);
transition:.18s ease;
}

.btn-light:hover{
transform:translateY(-2px);
background:#EEF2FF;
color:var(--primary);
}

/* CARD */
.form-shell{
background:rgba(255,255,255,.84);
backdrop-filter:blur(18px);
border-radius:30px;
overflow:hidden;
border:1px solid rgba(255,255,255,.88);
box-shadow:0 24px 50px rgba(15,23,42,.05);
}

.shell-top{
display:flex;
justify-content:space-between;
align-items:center;
gap:18px;
padding:26px 28px;
border-bottom:1px solid var(--line);
}

.shell-top h2{
margin:0;
font-size:22px;
font-weight:900;
color:var(--text);
}

.shell-top p{
margin:6px 0 0;
font-size:14px;
color:var(--muted);
}

.top-status{
padding:8px 14px;
border-radius:999px;
background:#DCFCE7;
color:#166534;
font-size:12px;
font-weight:800;
white-space:nowrap;
}

.shell-body{
padding:30px;
}

/* FORM */
.form-shell label{
font-weight:800;
color:var(--text);
margin-bottom:8px;
}
/* =========================
   INPUT SYSTEM PREMIUM FIX
========================= */

.form-shell .form-control,
.form-shell .form-select,
.form-shell input,
.form-shell select,
.form-shell textarea{
width:100%;
border-radius:16px;
border:1px solid var(--line);
font-size:15px;
background:#fff;
transition:.18s ease;
box-shadow:none;
color:var(--text);

/* 🔥 FIX CLAVE */
height:auto;
min-height:52px;
padding:12px 16px;
line-height:1.4;
}

/* INPUTS */
.form-shell input,
.form-shell .form-control{
min-height:52px;

}

/* SELECTS */
.form-shell select,
.form-shell .form-select{
min-height:54px;
padding-right:40px;
appearance:none;
}

/* TEXTAREA */
.form-shell textarea{
min-height:140px;
padding:14px 16px;
line-height:1.6;
resize:vertical;
}

/* PLACEHOLDER FIX */
.form-shell input::placeholder,
.form-shell textarea::placeholder{
color:#94A3B8;
opacity:1;
font-size:14px;
}

/* FOCUS CLEAN */
.form-shell input:focus,
.form-shell select:focus,
.form-shell textarea:focus,
.form-shell .form-control:focus,
.form-shell .form-select:focus{
border-color:var(--primary);
box-shadow:0 0 0 4px rgba(99,102,241,.12);
outline:none;
}

/* LABEL CONSISTENTE */
.form-shell label{
font-weight:800;
font-size:13px;
margin-bottom:8px;
color:var(--text);
display:block;
}

/* FIX PARA INPUTS CORTOS (evita “aplastado”) */
.field-laboratorios-codigo input,
.field-laboratorios-capacidad input{
max-width:260px;
}



/* BUTTON SAVE */
.form-shell .btn-success,
.form-shell button[type=submit]{
border:none;
padding:14px 24px;
border-radius:18px;
font-weight:900;
color:#fff;
background:linear-gradient(135deg,var(--primary),var(--primary2));
box-shadow:0 16px 28px rgba(99,102,241,.22);
transition:.18s ease;
}

.form-shell .btn-success:hover,
.form-shell button[type=submit]:hover{
transform:translateY(-2px);
}

/* ERROR */
.help-block,
.invalid-feedback{
font-size:13px;
margin-top:6px;
}

/* MOBILE */
@media(max-width:980px){

.edit-page{
padding:16px;
}

.hero-box{
grid-template-columns:1fr;
padding:22px;
}

.hero-right,
.btn-light{
width:100%;
}

.shell-top{
flex-direction:column;
align-items:flex-start;
padding:22px;
}

.shell-body{
padding:22px;
}

}

@media(max-width:640px){

.hero-box,
.form-shell{
border-radius:24px;
}

.hero-box h1{
font-size:28px;
}

.hero-meta{
flex-direction:column;
}

.shell-body{
padding:18px;
}

}

@keyframes fadeUp{
from{
opacity:0;
transform:translateY(12px);
}
to{
opacity:1;
transform:translateY(0);
}
}
</style>