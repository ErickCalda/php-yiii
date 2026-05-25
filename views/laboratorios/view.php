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


```css id="v3n8qd"
/* ==========================================
   EJECUTIVA01 — LAB VIEW
   Executive Desktop Edition
========================================== */

:root{

    --exec-bg:#eef3f8;

    --exec-surface:#ffffff;

    --exec-border:#ccd6e2;

    --exec-text:#1e293b;

    --exec-soft:#64748b;

    --exec-primary:#23476b;

    --exec-primary2:#2f5f91;

    --exec-accent:#2563eb;

    --exec-accent-soft:#dbeafe;

    --exec-success:#166534;
    --exec-success-bg:#dcfce7;

    --exec-danger:#991b1b;
    --exec-danger-bg:#fee2e2;

    --exec-warning:#9a3412;
    --exec-warning-bg:#ffedd5;

    --exec-shadow:
        0 1px 2px rgba(0,0,0,.04);

    --exec-radius:5px;
}


/* =========================
   PAGE
========================= */

.lab-show-page{

    max-width:1280px;

    margin:auto;

    padding:24px;

    background:var(--exec-bg);

    min-height:100vh;

    font-family:
        "Segoe UI",
        Inter,
        sans-serif;
}


/* =========================
   HERO
========================= */

.hero-panel{

    display:grid;

    grid-template-columns:1fr auto;

    gap:24px;

    margin-bottom:20px;

    padding:26px 28px;

    background:
        linear-gradient(
            135deg,
            #1e3a5f,
            #2f5f91
        );

    border:1px solid #345a84;

    border-radius:var(--exec-radius);

    box-shadow:var(--exec-shadow);
}

.top-line{

    display:flex;

    align-items:center;

    flex-wrap:wrap;

    gap:10px;

    margin-bottom:14px;
}

.code-pill{

    display:inline-flex;

    align-items:center;

    height:30px;

    padding:0 12px;

    background:#e8f0ff;

    border:1px solid #c7d9ff;

    border-radius:4px;

    color:#1d4ed8;

    font-size:12px;

    font-weight:700;

    letter-spacing:.4px;
}

.hero-panel h1{

    margin:0;

    font-size:36px;

    font-weight:700;

    letter-spacing:-.5px;

    color:#fff;
}

.hero-panel p{

    margin:12px 0 0;

    max-width:680px;

    line-height:1.7;

    color:rgba(255,255,255,.82);

    font-size:14px;
}


/* =========================
   HERO ACTIONS
========================= */

.hero-actions{

    display:flex;

    gap:10px;

    align-items:flex-start;

    flex-wrap:wrap;
}


/* =========================
   BUTTONS
========================= */

.btn-lite,
.btn-main,
.btn-danger{

    height:42px;

    padding:0 18px;

    display:inline-flex;

    align-items:center;

    justify-content:center;

    border-radius:4px;

    text-decoration:none;

    font-size:13px;

    font-weight:700;

    transition:.15s ease;
}

.btn-lite{

    background:
        linear-gradient(
            to bottom,
            #ffffff,
            #eef3f8
        );

    border:1px solid #cad5e2;

    color:#1e293b;
}

.btn-main{

    background:
        linear-gradient(
            to bottom,
            #376ba6,
            #24476f
        );

    border:1px solid #2d5682;

    color:#fff;
}

.btn-danger{

    background:
        linear-gradient(
            to bottom,
            #ffffff,
            #fff5f5
        );

    border:1px solid #fecaca;

    color:#b91c1c;
}

.btn-lite:hover,
.btn-main:hover,
.btn-danger:hover{

    transform:translateY(-1px);
}


/* =========================
   QUICK GRID
========================= */

.quick-grid{

    display:grid;

    grid-template-columns:
        repeat(4,1fr);

    gap:16px;

    margin-bottom:20px;
}

.q-card{

    padding:18px;

    background:var(--exec-surface);

    border:1px solid var(--exec-border);

    border-top:4px solid var(--exec-accent);

    border-radius:var(--exec-radius);

    box-shadow:var(--exec-shadow);
}

.q-card small{

    display:block;

    margin-bottom:8px;

    color:var(--exec-soft);

    font-size:11px;

    font-weight:700;

    text-transform:uppercase;

    letter-spacing:.5px;
}

.q-card strong{

    color:var(--exec-text);

    font-size:18px;

    font-weight:700;

    line-height:1.4;
}


/* =========================
   CONTENT
========================= */

.content-grid{

    display:grid;

    grid-template-columns:1fr 1fr;

    gap:18px;
}


/* =========================
   CARD
========================= */

.glass-card{

    background:var(--exec-surface);

    border:1px solid var(--exec-border);

    border-radius:var(--exec-radius);

    box-shadow:var(--exec-shadow);

    overflow:hidden;
}

.card-head{

    display:flex;

    justify-content:space-between;

    align-items:center;

    gap:12px;

    padding:16px 20px;

    background:
        linear-gradient(
            to bottom,
            #f8fbff,
            #eef4fa
        );

    border-bottom:1px solid #d9e3ee;
}

.card-head h3{

    margin:0;

    color:var(--exec-text);

    font-size:16px;

    font-weight:700;
}

.card-head span{

    color:var(--exec-soft);

    font-size:12px;

    font-weight:700;
}


/* =========================
   INFO
========================= */

.info-list{

    display:flex;

    flex-direction:column;
}

.info-row{

    display:grid;

    grid-template-columns:160px 1fr;

    gap:16px;

    padding:14px 20px;

    border-bottom:1px solid #edf2f7;

    align-items:flex-start;
}

.info-row:last-child{

    border-bottom:none;
}

.info-row label{

    color:var(--exec-soft);

    font-size:12px;

    font-weight:700;

    text-transform:uppercase;

    letter-spacing:.4px;
}

.info-row span{

    color:var(--exec-text);

    font-size:14px;

    font-weight:600;

    line-height:1.7;
}

.info-row.block{

    grid-template-columns:1fr;
}


/* =========================
   BADGES
========================= */

.badge-state{

    display:inline-flex;

    align-items:center;

    height:30px;

    padding:0 12px;

    border-radius:4px;

    font-size:12px;

    font-weight:700;

    border:1px solid transparent;
}

.badge-green{

    background:var(--exec-success-bg);

    color:var(--exec-success);

    border-color:#86efac;
}

.badge-blue{

    background:#dbeafe;

    color:#1d4ed8;

    border-color:#93c5fd;
}

.badge-red{

    background:var(--exec-danger-bg);

    color:var(--exec-danger);

    border-color:#fca5a5;
}

.badge-orange{

    background:var(--exec-warning-bg);

    color:var(--exec-warning);

    border-color:#fdba74;
}

.badge-gray{

    background:#e5e7eb;

    color:#111827;

    border-color:#cbd5e1;
}


/* =========================
   RESPONSIVE
========================= */

@media(max-width:1080px){

    .quick-grid{

        grid-template-columns:
            repeat(2,1fr);
    }

    .content-grid{

        grid-template-columns:1fr;
    }
}

@media(max-width:820px){

    .hero-panel{

        grid-template-columns:1fr;
    }

    .hero-actions{

        width:100%;
    }

    .hero-actions a{

        flex:1;
    }
}

@media(max-width:640px){

    .lab-show-page{

        padding:14px;
    }

    .hero-panel{

        padding:20px;
    }

    .hero-panel h1{

        font-size:28px;
    }

    .quick-grid{

        grid-template-columns:1fr;
    }

    .info-row{

        grid-template-columns:1fr;

        gap:6px;
    }

    .hero-actions{

        flex-direction:column;
    }

    .hero-actions a{

        width:100%;
    }
}










```css id="d7k2mx"
/* ==========================================
   EJECUTIVA01 — MICRODETAILS PACK
   Elegancia corporativa sutil
========================================== */


/* =========================
   TRANSICIONES SUAVES
========================= */

.hero-panel,
.glass-card,
.q-card,
.btn-main,
.btn-lite,
.btn-danger,
.info-row,
.badge-state,
.code-pill{

    transition:
        background .18s ease,
        border-color .18s ease,
        box-shadow .18s ease,
        transform .18s ease,
        color .18s ease;
}


/* =========================
   HERO PREMIUM LIGHT
========================= */

.hero-panel{

    position:relative;

    overflow:hidden;
}

/* luz suave superior */
.hero-panel::before{

    content:"";

    position:absolute;

    top:0;
    left:0;
    right:0;

    height:1px;

    background:
        linear-gradient(
            90deg,
            transparent,
            rgba(255,255,255,.45),
            transparent
        );
}

/* brillo lateral */
.hero-panel::after{

    content:"";

    position:absolute;

    top:0;
    left:-120px;

    width:220px;
    height:100%;

    background:
        linear-gradient(
            90deg,
            transparent,
            rgba(255,255,255,.06),
            transparent
        );

    transform:skewX(-18deg);

    pointer-events:none;
}


/* =========================
   TARJETAS MÁS PREMIUM
========================= */

.glass-card,
.q-card{

    position:relative;

    overflow:hidden;
}

/* línea brillante superior */
.glass-card::before,
.q-card::before{

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
            rgba(255,255,255,.9),
            transparent
        );
}

/* profundidad elegante */
.glass-card{

    box-shadow:
        0 1px 2px rgba(15,23,42,.04),
        0 8px 18px rgba(15,23,42,.03);
}

.glass-card:hover{

    border-color:#b8c8d9;

    box-shadow:
        0 1px 2px rgba(15,23,42,.04),
        0 14px 30px rgba(15,23,42,.06);

    transform:translateY(-2px);
}

.q-card:hover{

    border-color:#b7c7d9;

    background:
        linear-gradient(
            to bottom,
            #ffffff,
            #f8fbff
        );

    transform:translateY(-1px);
}


/* =========================
   HEADERS MÁS CORPORATIVOS
========================= */

.card-head{

    position:relative;
}

.card-head::after{

    content:"";

    position:absolute;

    left:0;
    bottom:0;

    width:100%;
    height:1px;

    background:
        linear-gradient(
            90deg,
            #d7e2ee,
            transparent
        );
}


/* =========================
   INFO ROWS ELEGANTES
========================= */

.info-row{

    position:relative;
}

.info-row:hover{

    background:
        linear-gradient(
            to right,
            rgba(37,99,235,.035),
            transparent
        );
}

/* mini accent line */
.info-row::before{

    content:"";

    position:absolute;

    left:0;
    top:10px;
    bottom:10px;

    width:2px;

    background:transparent;

    transition:.18s ease;
}

.info-row:hover::before{

    background:#2563eb;
}


/* =========================
   BOTONES PREMIUM
========================= */

.btn-main,
.btn-lite,
.btn-danger{

    position:relative;

    overflow:hidden;
}

/* brillo interno */
.btn-main::before,
.btn-lite::before,
.btn-danger::before{

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

.btn-main:hover{

    box-shadow:
        0 10px 20px rgba(37,99,235,.16);

    border-color:#4b77a8;
}

.btn-lite:hover{

    background:
        linear-gradient(
            to bottom,
            #ffffff,
            #f3f7fb
        );

    border-color:#b7c6d6;

    box-shadow:
        0 4px 10px rgba(15,23,42,.05);
}

.btn-danger:hover{

    background:
        linear-gradient(
            to bottom,
            #fff,
            #fff1f1
        );

    box-shadow:
        0 6px 14px rgba(185,28,28,.08);
}


/* =========================
   BADGES MÁS FINOS
========================= */

.badge-state,
.code-pill{

    position:relative;

    overflow:hidden;
}

/* pequeño reflejo */
.badge-state::after,
.code-pill::after{

    content:"";

    position:absolute;

    top:0;
    left:0;
    right:0;

    height:1px;

    background:
        linear-gradient(
            90deg,
            transparent,
            rgba(255,255,255,.85),
            transparent
        );
}


/* =========================
   TIPOGRAFÍA MÁS FINA
========================= */

.hero-panel h1{

    text-shadow:
        0 1px 1px rgba(0,0,0,.08);
}

.card-head h3{

    letter-spacing:.2px;
}

.info-row span{

    text-rendering:optimizeLegibility;
}


/* =========================
   QUICK CARDS
========================= */

.q-card{

    background:
        linear-gradient(
            to bottom,
            #ffffff,
            #fbfdff
        );
}

.q-card strong{

    letter-spacing:-.2px;
}


/* =========================
   EFECTO DE CRISTAL SUAVE
========================= */

.glass-card{

    backdrop-filter:blur(3px);
}


/* =========================
   SEPARADORES MÁS LIMPIOS
========================= */

.info-row{

    border-bottom:
        1px solid rgba(226,232,240,.75);
}


/* =========================
   SCROLLBAR CORPORATIVO
========================= */

::-webkit-scrollbar{

    width:10px;
    height:10px;
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
```



</style>