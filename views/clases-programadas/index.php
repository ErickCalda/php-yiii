<?php

use yii\helpers\Html;
use yii\widgets\Pjax;

$this->title = 'Horario de Clases';
$this->params['breadcrumbs'][] = $this->title;

$models = $dataProvider->getModels();

/* AGRUPAR POR DÍA */
$horario = [];

foreach ($models as $m) {
    $dia = trim(strtolower($m->dia_semana ?? ''));
    $horario[$dia][] = $m;
}

/* SOLO UNA VEZ CADA DÍA */
$dias = [
    'lunes',
    'martes',
    'miercoles',
    'jueves',
    'viernes',
  
];
?>

<div class="schedule-page">

    <!-- HERO -->
    <div class="hero-panel">

        <div>
            <span class="mini-badge">Vista Horario</span>
            <h1><?= Html::encode($this->title) ?></h1>
            <p>Distribución semanal de clases programadas en tiempo real</p>
        </div>

        <div class="cp-actions">
            <?= Html::a('+ Curso', ['cursos/create'], ['class' => 'btn-soft']) ?>
            <?= Html::a('+ Materia', ['materias/create'], ['class' => 'btn-soft']) ?>
            <?= Html::a('+ Período', ['periodos-academicos/create'], ['class' => 'btn-soft']) ?>
        </div>

    </div>

    <?php Pjax::begin(); ?>

    <div class="schedule-grid">

        <?php foreach ($dias as $dia): ?>

            <div class="day-column">

                <div class="day-header">
                    <?= ucfirst($dia) ?>
                </div>

                <?php if (!empty($horario[$dia])): ?>

                    <?php foreach ($horario[$dia] as $m): ?>

                        <div class="class-block">

                            <!-- TOP -->
                            <div class="class-top">

                                <div class="class-name">
                                    <?= $m->usuarios->nombre ?? 'Docente' ?>
                                    <?= $m->usuarios->apellido ?? '' ?>
                                </div>

                                <div class="class-status <?= $m->estado ? 'on' : 'off' ?>">
                                    <?= $m->estado ? 'Activo' : 'Inactivo' ?>
                                </div>

                            </div>

                            <!-- BODY -->
                            <div class="class-time">
                                <?= $m->hora_inicio ?> — <?= $m->hora_fin ?>
                            </div>

                            <div class="class-title">
                                <?= $m->materias->nombre ?? 'Sin materia' ?>
                            </div>

                            <div class="class-sub">
                                <?= $m->cursos->nombre ?? 'Curso' ?>
                            </div>

                            <div class="class-meta">
                                🧪 <?= $m->laboratorios->nombre ?? 'Laboratorio' ?>
                            </div>

                            <!-- ACTIONS -->
                            <div class="class-actions">

                                <?= Html::a('Ver', ['view', 'id' => $m->id]) ?>

                                <?= Html::a('Editar', ['update', 'id' => $m->id]) ?>

                                <?= Html::a('Eliminar', ['delete', 'id' => $m->id], [
                                    'data-method' => 'post',
                                    'data-confirm' => '¿Eliminar clase?'
                                ]) ?>

                            </div>

                        </div>

                    <?php endforeach; ?>

                <?php else: ?>

                    <div class="empty-slot">
                        Sin clases
                    </div>

                <?php endif; ?>

            </div>

        <?php endforeach; ?>

    </div>

    <?php Pjax::end(); ?>

</div>

<?= Html::a('＋ Nueva Clase Programada', ['create'], [
    'class' => 'cp-fab'
]) ?>


<style>




/* =========================
   HORARIO APPLE STYLE FINAL
   (100% tu paleta + limpio)
========================= */

:root{
    --bg:#F8FAFC;
    --surface:rgba(255,255,255,.75);
    --card:#FFFFFF;

    --text:#0F172A;
    --muted:#64748B;

    --line:#E2E8F0;

    --indigo:#6366F1;
    --indigo-dark:#4F46E5;

    --success:#16A34A;
    --danger:#DC2626;

    --shadow:0 10px 25px rgba(15,23,42,.06);
    --shadow-soft:0 4px 12px rgba(15,23,42,.04);
}

/* BASE */
.schedule-page{
    padding:18px;
    background:var(--bg);
    min-height:100vh;
    font-family:system-ui,-apple-system,sans-serif;
}

/* HERO */
.hero-panel{
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:16px;

    padding:20px;
    margin-bottom:16px;

    background:var(--surface);
    backdrop-filter:blur(12px);

    border:1px solid var(--line);
    border-radius:22px;

    box-shadow:var(--shadow-soft);
}

.hero-panel h1{
    margin:0;
    font-size:28px;
    font-weight:900;
    color:var(--text);
    letter-spacing:-.02em;
}

.hero-panel p{
    margin:6px 0 0;
    font-size:13px;
    color:var(--muted);
}

/* BADGE */
.mini-badge{
    display:inline-block;
    padding:5px 10px;
    margin-bottom:8px;

    border-radius:999px;
    background:#EEF2FF;
    color:var(--indigo);

    font-size:11px;
    font-weight:800;
}

/* BOTONES */
.cp-actions{
    display:flex;
    gap:8px;
    flex-wrap:wrap;
}

.btn-soft{
    padding:9px 13px;
    border-radius:12px;
    border:1px solid var(--line);

    background:#fff;
    color:var(--text);

    font-size:12px;
    font-weight:800;
    text-decoration:none;

    transition:.2s ease;
}

.btn-soft:hover{
    transform:translateY(-1px);
    box-shadow:var(--shadow-soft);
}

/* GRID */
.schedule-grid{
    display:grid;
    grid-template-columns:repeat(6,minmax(170px,1fr));
    gap:10px;
    align-items:start;
}

/* DIA */
.day-column{
    background:var(--surface);
    backdrop-filter:blur(10px);

    border:1px solid var(--line);
    border-radius:18px;

    padding:10px;
}

.day-header{
    font-size:12px;
    font-weight:900;
    color:var(--indigo);

    margin-bottom:8px;
    padding-bottom:6px;

    border-bottom:1px solid var(--line);
}

/* CLASE (ULTRA COMPACTO) */
.class-block{
    background:#fff;
    border:1px solid var(--line);
    border-left:3px solid var(--indigo);

    border-radius:12px;

    padding:7px;
    margin-bottom:6px;

    transition:.18s ease;
}

.class-block:hover{
    transform:translateY(-1px);
    box-shadow:var(--shadow-soft);
}

/* TOP */
.class-top{
    display:flex;
    justify-content:space-between;
    gap:6px;
    margin-bottom:4px;
}

.class-name{
    font-size:10px;
    font-weight:900;
    color:var(--text);
    line-height:1.1;
    max-width:90px;
}

/* ESTADO */
.class-status{
    padding:2px 6px;
    border-radius:999px;
    font-size:9px;
    font-weight:900;
}

.class-status.on{
    background:#ECFDF5;
    color:var(--success);
}

.class-status.off{
    background:#FEF2F2;
    color:var(--danger);
}

/* =========================
   HORA MINIMAL PREMIUM
========================= */
.class-time{
    display:inline-block;

    padding:3px 7px;
    margin-bottom:5px;

    border-radius:8px;

    font-size:10px;
    font-weight:800;
    letter-spacing:-.01em;

    color:var(--indigo);
    background:#EEF2FF;
}

/* INFO */
.class-title{
    font-size:11px;
    font-weight:900;
    color:var(--text);
    line-height:1.15;
}

.class-sub{
    font-size:9.5px;
    color:var(--muted);
}

.class-meta{
    font-size:9px;
    color:var(--muted);
}

/* ACCIONES */
.class-actions{
    display:grid;
    grid-template-columns:repeat(3,1fr);
    gap:3px;
    margin-top:6px;
}

.class-actions a{
    text-align:center;
    padding:4px;

    border-radius:7px;
    border:1px solid var(--line);

    font-size:9px;
    font-weight:800;

    background:#F8FAFC;
    color:var(--text);
    text-decoration:none;
}

.class-actions a:hover{
    background:#EEF2FF;
    color:var(--indigo);
}

/* VACIO */
.empty-slot{
    text-align:center;
    padding:14px 0;
    font-size:11px;
    color:var(--muted);
}

/* FAB */
.cp-fab{
    position:fixed;
    right:20px;
    bottom:20px;

    padding:13px 16px;
    border-radius:14px;

    background:var(--indigo);
    color:#fff;

    font-size:13px;
    font-weight:900;
    text-decoration:none;

    box-shadow:0 10px 25px rgba(99,102,241,.25);
}

.cp-fab:hover{
    background:var(--indigo-dark);
}

/* RESPONSIVE */
@media(max-width:1400px){
    .schedule-grid{grid-template-columns:repeat(3,1fr);}
}

@media(max-width:900px){
    .schedule-grid{grid-template-columns:repeat(2,1fr);}
}

@media(max-width:600px){
    .schedule-grid{grid-template-columns:1fr;}
}











/* =====================================
   RESPONSIVE PERFECTO SIN PERDER HORARIO
   REEMPLAZA SOLO MEDIA QUERIES + GRID
===================================== */

/* GRID BASE */
.schedule-grid{
    display:grid;
    grid-template-columns:repeat(6,minmax(170px,1fr));
    gap:10px;
    align-items:start;
    overflow-x:auto;
    padding-bottom:4px;
}

/* SCROLL BONITO */
.schedule-grid::-webkit-scrollbar{
    height:8px;
}

.schedule-grid::-webkit-scrollbar-track{
    background:#E2E8F0;
    border-radius:999px;
}

.schedule-grid::-webkit-scrollbar-thumb{
    background:#CBD5E1;
    border-radius:999px;
}

/* =============================
   DESKTOP GRANDE
============================= */
@media (min-width:1600px){

    .schedule-grid{
        grid-template-columns:repeat(6,1fr);
    }

    .schedule-page{
        padding:22px;
    }

}

/* =============================
   LAPTOP NORMAL
============================= */
@media (max-width:1399px){

    .schedule-grid{
        grid-template-columns:repeat(6,minmax(190px,1fr));
    }

}

/* =============================
   TABLET HORIZONTAL
   mantiene forma horario
============================= */
@media (max-width:1190px){

    .schedule-grid{
        grid-template-columns:repeat(6,minmax(180px,1fr));
    }

    .hero-panel{
        flex-wrap:wrap;
        align-items:flex-start;
    }

}

/* =============================
   TABLET VERTICAL
   scroll horizontal elegante
============================= */
@media (max-width:980px){

    .schedule-grid{
        grid-template-columns:repeat(6,180px);
    }

    .schedule-page{
        padding:14px;
    }

    .hero-panel h1{
        font-size:24px;
    }

}

/* =============================
   MOBILE GRANDE
   sigue pareciendo horario real
============================= */
@media (max-width:768px){

    .schedule-grid{
        grid-template-columns:repeat(6,165px);
        gap:8px;
    }

    .hero-panel{
        padding:16px;
        border-radius:18px;
    }

    .btn-soft{
        padding:8px 12px;
        font-size:11px;
    }

    .cp-fab{
        right:14px;
        bottom:14px;
    }

}

/* =============================
   MOBILE PEQUEÑO
============================= */
@media (max-width:560px){

    .schedule-grid{
        grid-template-columns:repeat(6,155px);
        gap:7px;
    }

    .schedule-page{
        padding:10px;
    }

    .hero-panel{
        flex-direction:column;
        align-items:flex-start;
        gap:12px;
    }

    .hero-panel h1{
        font-size:21px;
    }

    .hero-panel p{
        font-size:12px;
    }

    .cp-actions{
        width:100%;
    }

    .btn-soft{
        flex:1;
        text-align:center;
    }

    .cp-fab{
        left:10px;
        right:10px;
        bottom:10px;
        text-align:center;
        border-radius:14px;
    }

}

/* =============================
   MOBILE MINI
============================= */
@media (max-width:390px){

    .schedule-grid{
        grid-template-columns:repeat(6,145px);
    }

    .hero-panel h1{
        font-size:19px;
    }

}




</style>