<?php

use app\models\ClasesProgramadas;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;

$this->title = 'Clases Programadas';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="cp-page">

    <!-- HEADER HERO -->
    <div class="cp-hero">
        <div>
            <h1><?= Html::encode($this->title) ?></h1>
            <p>Gestión académica de clases programadas en tiempo real</p>
        </div>

        <div class="cp-actions">
           
            <?= Html::a('+ Curso', ['cursos/create'], ['class' => 'btn ghost']) ?>
            <?= Html::a('+ Materia', ['materias/create'], ['class' => 'btn ghost']) ?>
            <?= Html::a('+ Período', ['periodos-academicos/create'], ['class' => 'btn ghost']) ?>
        </div>
    </div>

    <?php Pjax::begin(); ?>

    <!-- GRID VISUAL CARDS -->
    <div class="cp-grid">

        <?php foreach ($dataProvider->models as $m): ?>

            <div class="cp-card">

                <div class="cp-card-top">
                    <div class="cp-tag">
                        <?= ucfirst($m->dia_semana) ?>
                    </div>

                    <div class="cp-status <?= $m->estado ? 'on' : 'off' ?>">
                        <?= $m->estado ? 'Activo' : 'Inactivo' ?>
                    </div>
                </div>

                <div class="cp-title">
                    <?= $m->materias->nombre ?? 'Sin materia' ?>
                </div>

                <div class="cp-sub">
                    <?= $m->cursos->nombre ?? 'Curso' ?> · <?= $m->periodosAcademicos->nombre ?? 'Periodo' ?>
                </div>

                <div class="cp-info">
                    <div><b>Lab:</b> <?= $m->laboratorios->nombre ?? 'N/A' ?></div>
                    <div><b>Docente:</b> <?= ($m->usuarios?->nombre ?? '') . ' ' . ($m->usuarios?->apellido ?? '') ?></div>
                </div>

                <div class="cp-time">
                    <?= $m->hora_inicio ?> → <?= $m->hora_fin ?>
                </div>

                <div class="cp-actions-card">
                    <?= Html::a('Ver', ['view', 'id' => $m->id]) ?>
                    <?= Html::a('Editar', ['update', 'id' => $m->id]) ?>
                    <?= Html::a('Eliminar', ['delete', 'id' => $m->id], [
                        'data-method' => 'post',
                        'data-confirm' => '¿Eliminar esta clase?'
                    ]) ?>
                </div>

            </div>

        <?php endforeach; ?>

    </div>

    <?php Pjax::end(); ?>

</div>

<style>

/* =========================
   BASE SYSTEM (PALETA)
========================= */
:root{
    --bg: #F8FAFC;
    --card: rgba(255,255,255,0.75);
    --text: #0F172A;
    --muted: #64748B;
    --border: #E2E8F0;
    --indigo: #6366F1;
    --indigo2: #4F46E5;
}



/* =========================
   PAGE
========================= */
.cp-page{
    padding: 25px;
    background: var(--bg);
    min-height: 100vh;
}

/* =========================
   HERO HEADER
========================= */
.cp-hero{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom: 18px;
    padding: 14px 18px;
    border-radius: 14px;
    background: white;
    border: 1px solid var(--border);
    box-shadow: 0 8px 25px rgba(15,23,42,0.05);
}

.cp-hero h1{
    margin:0;
    font-size: 18px;
}

.cp-hero p{
    margin:2px 0 0 0;
    font-size: 12px;
}
/* =========================
   BUTTONS
========================= */
.cp-actions{
    display:flex;
    gap:10px;
    flex-wrap:wrap;
}

.btn{
    padding:10px 14px;
    border-radius: 12px;
    text-decoration:none;
    font-size:13px;
    transition:0.25s ease;
}

.btn.primary{
    background: var(--indigo);
    color:white;
    box-shadow: 0 10px 25px rgba(99,102,241,0.25);
}

.btn.primary:hover{
    transform: translateY(-2px);
    background: var(--indigo2);
}

.btn.ghost{
    background: transparent;
    border:1px solid var(--border);
    color: var(--text);
}

.btn.ghost:hover{
    border-color: var(--indigo);
    color: var(--indigo);
}

/* =========================
   GRID (FULL WIDTH)
========================= */
.cp-grid{
    display:grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 18px;
}

/* =========================
   CARD (PRO LEVEL)
========================= */
.cp-card{
    background: var(--card);
    backdrop-filter: blur(14px);
    border:1px solid var(--border);
    border-radius: 18px;
    padding:18px;
    transition:0.25s ease;
    position:relative;
    overflow:hidden;
}

.cp-card:hover{
    transform: translateY(-6px);
    box-shadow: 0 18px 45px rgba(15,23,42,0.12);
}

/* top row */
.cp-card-top{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:10px;
}

.cp-tag{
    font-size:12px;
    padding:5px 10px;
    border-radius:999px;
    background:#EEF2FF;
    color:var(--indigo);
}

.cp-status{
    font-size:12px;
    padding:5px 10px;
    border-radius:999px;
}

.cp-status.on{
    background:#DCFCE7;
    color:#16A34A;
}

.cp-status.off{
    background:#FEE2E2;
    color:#DC2626;
}

/* title */
.cp-title{
    font-size:16px;
    font-weight:600;
    color:var(--text);
    margin-top:6px;
}

/* subtitle */
.cp-sub{
    font-size:13px;
    color:var(--muted);
    margin-top:3px;
}

/* info block */
.cp-info{
    margin-top:12px;
    font-size:13px;
    color:var(--text);
    display:flex;
    flex-direction:column;
    gap:4px;
}

/* time */
.cp-time{
    margin-top:12px;
    font-weight:600;
    color:var(--indigo);
}

/* actions */
.cp-actions-card{
    margin-top:14px;
    display:flex;
    gap:12px;
    font-size:13px;
}

.cp-actions-card a{
    color:var(--indigo);
    text-decoration:none;
    transition:0.2s;
}

.cp-actions-card a:hover{
    color:var(--indigo2);
    transform: translateY(-1px);
}


html, body{
    height: 100%;
    overflow: hidden;
}

</style>