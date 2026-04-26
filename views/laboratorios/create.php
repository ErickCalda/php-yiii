<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Laboratorios $model */
/** @var array $tipos */
/** @var array $estados */
/** @var array $ubicaciones */

$this->title = 'Nuevo Laboratorio';

$this->params['breadcrumbs'][] = [
    'label' => 'Laboratorios',
    'url' => ['index']
];

$this->params['breadcrumbs'][] = $this->title;
?>

<div class="page-create">

    <!-- HERO -->
    <section class="create-hero">

        <div class="hero-left">

            <span class="hero-badge">
                Nuevo Registro
            </span>

            <h1><?= Html::encode($this->title) ?></h1>

            <p>
                Registra un nuevo laboratorio con información completa:
                tipo, estado, ubicación y capacidad operativa.
            </p>

        </div>

        <div class="hero-right">

            <?= Html::a(
                '← Volver',
                ['index'],
                ['class' => 'btn-light']
            ) ?>

        </div>

    </section>

    <!-- FORM CARD -->
    <section class="create-card">

        <div class="card-top">

            <div>
                <h2>Información Inicial</h2>
                <p>
                    Completa los datos requeridos para crear el laboratorio.
                </p>
            </div>

            <span class="lab-chip">
                Nuevo
            </span>

        </div>

        <div class="card-body">

<?= $this->render('_form', [
    'model' => $model,
    'tipos' => $tipos,
    'estados' => $estados,
    'ubicaciones' => $ubicaciones,
    'responsables' => $responsables, // 🔥 ESTE ES EL QUE FALTA
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
.page-create{
max-width:1100px;
margin:auto;
padding:24px;
}

/* HERO */
.create-hero{
display:grid;
grid-template-columns:1fr auto;
gap:18px;
align-items:center;
padding:28px;
margin-bottom:22px;
border-radius:30px;
background:rgba(255,255,255,.78);
backdrop-filter:blur(18px);
border:1px solid rgba(255,255,255,.75);
box-shadow:0 20px 40px rgba(15,23,42,.06);
}

.hero-badge{
display:inline-block;
padding:7px 12px;
border-radius:999px;
background:#EEF2FF;
color:var(--primary);
font-size:12px;
font-weight:800;
margin-bottom:12px;
}

.create-hero h1{
margin:0;
font-size:clamp(28px,5vw,42px);
font-weight:800;
letter-spacing:-1px;
color:var(--text);
}

.create-hero p{
margin:10px 0 0;
color:var(--muted);
line-height:1.6;
max-width:650px;
}

/* BUTTON */
.btn-light{
display:inline-flex;
align-items:center;
justify-content:center;
padding:13px 18px;
border-radius:18px;
text-decoration:none;
font-weight:700;
color:var(--text);
background:#fff;
border:1px solid var(--line);
transition:.18s ease;
}

.btn-light:hover{
background:#EEF2FF;
color:var(--primary);
transform:translateY(-2px);
}

/* CARD */
.create-card{
background:rgba(255,255,255,.82);
backdrop-filter:blur(18px);
border:1px solid rgba(255,255,255,.75);
border-radius:30px;
box-shadow:0 24px 50px rgba(15,23,42,.06);
overflow:hidden;
}

.card-top{
display:flex;
justify-content:space-between;
align-items:flex-start;
gap:18px;
padding:26px 28px;
border-bottom:1px solid var(--line);
}

.card-top h2{
margin:0;
font-size:22px;
font-weight:800;
color:var(--text);
}

.card-top p{
margin:6px 0 0;
font-size:14px;
color:var(--muted);
}

.lab-chip{
padding:8px 14px;
border-radius:999px;
background:#DCFCE7;
color:#166534;
font-size:13px;
font-weight:800;
white-space:nowrap;
}

.card-body{
padding:30px;
}

/* FORM */
.create-card .form-control,
.create-card .form-select,
.create-card select,
.create-card input,
.create-card textarea{
border-radius:16px;
border:1px solid var(--line);
padding:13px 15px;
transition:.18s ease;
box-shadow:none;
}

.create-card textarea{
min-height:130px;
resize:vertical;
}

.create-card .form-control:focus,
.create-card .form-select:focus,
.create-card select:focus,
.create-card input:focus,
.create-card textarea:focus{
border-color:var(--primary);
box-shadow:0 0 0 4px rgba(99,102,241,.10);
outline:none;
}

.create-card label{
font-weight:700;
color:var(--text);
margin-bottom:8px;
}

/* SUBMIT */
.create-card .btn-success,
.create-card button[type=submit]{
border:none;
padding:14px 22px;
border-radius:18px;
font-weight:800;
color:#fff;
background:linear-gradient(135deg,var(--primary),var(--primary2));
box-shadow:0 14px 28px rgba(99,102,241,.22);
transition:.2s ease;
}

.create-card .btn-success:hover,
.create-card button[type=submit]:hover{
transform:translateY(-2px);
}

/* MOBILE */
@media(max-width:900px){

.page-create{
padding:16px;
}

.create-hero{
grid-template-columns:1fr;
padding:22px;
}

.hero-right,
.btn-light{
width:100%;
}

.card-top{
flex-direction:column;
align-items:flex-start;
padding:22px;
}

.card-body{
padding:22px;
}

}

@media(max-width:480px){

.create-hero,
.create-card{
border-radius:24px;
}

.create-hero h1{
font-size:26px;
}

.card-body{
padding:18px;
}

}
</style>