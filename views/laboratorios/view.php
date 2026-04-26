<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Laboratorios $model */

$this->title = $model->nombre;

$this->params['breadcrumbs'][] = [
    'label' => 'Laboratorios',
    'url'   => ['index']
];

$this->params['breadcrumbs'][] = $this->title;

/**
 * 🔥 RELACIONES SEGURAS (sin crashes)
 */
$estadoNombre = $model->estado ? $model->estado->nombre : 'Sin estado';
$estadoColor  = $model->estado ? strtolower($model->estado->color) : 'gray';

$tipoNombre   = $model->tipo ? $model->tipo->nombre : 'General';
$ubicacion    = $model->ubicacionTexto ?: '-';

$responsableNombre = $model->responsable
    ? $model->responsable->nombre . ' ' . $model->responsable->apellido
    : 'Sin asignar';

?>

<div class="lab-show-page">

<!-- HERO -->
<section class="hero-panel">

    <div class="hero-left">

        <div class="top-line">

            <span class="code-pill">
                <?= Html::encode($model->codigo) ?>
            </span>

            <span class="badge-state badge-<?= Html::encode($estadoColor) ?>">
                <?= Html::encode($estadoNombre) ?>
            </span>

        </div>

        <h1><?= Html::encode($model->nombre) ?></h1>

        <p>
            Vista ejecutiva del laboratorio con información operativa,
            capacidad instalada y ubicación física.
        </p>

    </div>

    <div class="hero-actions">

        <?= Html::a('← Volver', ['index'], ['class' => 'btn-lite']) ?>

        <?= Html::a('Editar', ['update', 'id' => $model->id], ['class' => 'btn-main']) ?>

        <?= Html::a('Eliminar', ['delete', 'id' => $model->id], [
            'class' => 'btn-danger',
            'data' => [
                'confirm' => '¿Deseas eliminar este laboratorio?',
                'method' => 'post'
            ]
        ]) ?>

    </div>

</section>

<!-- QUICK INFO -->
<section class="quick-grid">

    <div class="q-card">
        <small>Tipo</small>
        <strong><?= Html::encode($tipoNombre) ?></strong>
    </div>

    <div class="q-card">
        <small>Capacidad</small>
        <strong><?= Html::encode($model->capacidad) ?> personas</strong>
    </div>

    <div class="q-card">
        <small>Ubicación</small>
        <strong><?= Html::encode($ubicacion) ?></strong>
    </div>

    <div class="q-card">
        <small>Responsable</small>
        <strong><?= Html::encode($responsableNombre) ?></strong>
    </div>

</section>

<!-- CONTENT -->
<section class="content-grid">

    <!-- LEFT -->
    <div class="glass-card">

        <div class="card-head">
            <h3>Información General</h3>
            <span>ID #<?= $model->id ?></span>
        </div>

        <div class="info-list">

            <div class="info-row">
                <label>Código</label>
                <span><?= Html::encode($model->codigo) ?></span>
            </div>

            <div class="info-row">
                <label>Nombre</label>
                <span><?= Html::encode($model->nombre) ?></span>
            </div>

            <div class="info-row">
                <label>Tipo</label>
                <span><?= Html::encode($tipoNombre) ?></span>
            </div>

            <div class="info-row">
                <label>Estado</label>
                <span><?= Html::encode($estadoNombre) ?></span>
            </div>

            <div class="info-row">
                <label>Capacidad</label>
                <span><?= Html::encode($model->capacidad) ?></span>
            </div>

            <div class="info-row">
                <label>Responsable</label>
                <span><?= Html::encode($responsableNombre) ?></span>
            </div>

        </div>

    </div>

    <!-- RIGHT -->
    <div class="glass-card">

        <div class="card-head">
            <h3>Detalles</h3>
            <span>Meta</span>
        </div>

        <div class="info-list">

            <div class="info-row">
                <label>Ubicación</label>
                <span><?= Html::encode($ubicacion) ?></span>
            </div>

            <div class="info-row">
                <label>Creado</label>
                <span><?= Html::encode($model->fecha_creacion) ?></span>
            </div>

            <div class="info-row">
                <label>Actualizado</label>
                <span><?= Html::encode($model->fecha_actualizacion) ?></span>
            </div>

            <div class="info-row block">
                <label>Descripción</label>
                <span>
                    <?= nl2br(Html::encode($model->descripcion ?: 'Sin descripción registrada.')) ?>
                </span>
            </div>

        </div>

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
.lab-show-page{
max-width:1250px;
margin:auto;
padding:22px;
}

/* HERO */
.hero-panel{
display:grid;
grid-template-columns:1fr auto;
gap:20px;
padding:28px;
margin-bottom:18px;
border-radius:30px;
background:rgba(255,255,255,.78);
backdrop-filter:blur(18px);
box-shadow:0 24px 50px rgba(15,23,42,.05);
border:1px solid rgba(255,255,255,.9);
}

.top-line{
display:flex;
gap:10px;
flex-wrap:wrap;
margin-bottom:14px;
}

.code-pill{
padding:7px 12px;
border-radius:999px;
background:#EEF2FF;
color:var(--primary);
font-size:12px;
font-weight:800;
}

.hero-panel h1{
margin:0;
font-size:clamp(30px,6vw,46px);
font-weight:900;
letter-spacing:-1.3px;
color:var(--text);
}

.hero-panel p{
margin:10px 0 0;
max-width:620px;
line-height:1.6;
color:var(--muted);
}

.hero-actions{
display:flex;
gap:10px;
align-items:flex-start;
flex-wrap:wrap;
}

/* BUTTONS */
.btn-lite,
.btn-main,
.btn-danger{
height:48px;
padding:0 18px;
display:inline-flex;
align-items:center;
justify-content:center;
border-radius:16px;
text-decoration:none;
font-weight:800;
transition:.2s ease;
}

.btn-lite{
background:#fff;
border:1px solid var(--line);
color:var(--text);
}

.btn-main{
background:linear-gradient(135deg,var(--primary),var(--primary2));
color:#fff;
box-shadow:0 16px 30px rgba(99,102,241,.24);
}

.btn-danger{
background:#fff;
border:1px solid #FECACA;
color:#DC2626;
}

.btn-lite:hover,
.btn-main:hover,
.btn-danger:hover{
transform:translateY(-2px);
}

/* QUICK */
.quick-grid{
display:grid;
grid-template-columns:repeat(3,1fr);
gap:16px;
margin-bottom:18px;
}

.q-card{
padding:18px;
border-radius:24px;
background:rgba(255,255,255,.82);
border:1px solid rgba(255,255,255,.9);
box-shadow:0 14px 26px rgba(15,23,42,.04);
}

.q-card small{
display:block;
font-size:12px;
color:var(--muted);
margin-bottom:6px;
font-weight:700;
}

.q-card strong{
font-size:18px;
color:var(--text);
}

/* CONTENT */
.content-grid{
display:grid;
grid-template-columns:1fr 1fr;
gap:18px;
}

.glass-card{
background:rgba(255,255,255,.84);
backdrop-filter:blur(18px);
border-radius:28px;
padding:22px;
border:1px solid rgba(255,255,255,.9);
box-shadow:0 18px 34px rgba(15,23,42,.05);
}

.card-head{
display:flex;
justify-content:space-between;
align-items:center;
gap:12px;
padding-bottom:14px;
margin-bottom:12px;
border-bottom:1px solid var(--line);
}

.card-head h3{
margin:0;
font-size:18px;
font-weight:900;
color:var(--text);
}

.card-head span{
font-size:12px;
color:var(--muted);
font-weight:700;
}

.info-list{
display:grid;
gap:10px;
}

.info-row{
display:grid;
grid-template-columns:140px 1fr;
gap:14px;
padding:12px 0;
border-bottom:1px solid #F1F5F9;
align-items:start;
}

.info-row:last-child{
border-bottom:none;
}

.info-row label{
font-size:13px;
font-weight:800;
color:var(--muted);
}

.info-row span{
font-size:14px;
font-weight:600;
color:var(--text);
line-height:1.6;
}

.info-row.block{
grid-template-columns:1fr;
}

/* BADGES */
.badge-state{
padding:7px 12px;
border-radius:999px;
font-size:12px;
font-weight:800;
}

.badge-green{background:#DCFCE7;color:#166534;border:1px solid #86EFAC;}
.badge-blue{background:#DBEAFE;color:#1D4ED8;border:1px solid #93C5FD;}
.badge-red{background:#FEE2E2;color:#991B1B;border:1px solid #FCA5A5;}
.badge-orange{background:#FFEDD5;color:#9A3412;border:1px solid #FDBA74;}
.badge-gray{background:#E5E7EB;color:#111827;border:1px solid #9CA3AF;}

/* MOBILE */
@media(max-width:980px){

.hero-panel{
grid-template-columns:1fr;
}

.hero-actions,
.hero-actions a{
width:100%;
}

.quick-grid{
grid-template-columns:1fr;
}

.content-grid{
grid-template-columns:1fr;
}

}

@media(max-width:640px){

.lab-show-page{
padding:14px;
}

.hero-panel,
.glass-card{
border-radius:24px;
padding:18px;
}

.info-row{
grid-template-columns:1fr;
gap:6px;
}

.hero-panel h1{
font-size:28px;
}

}
</style>