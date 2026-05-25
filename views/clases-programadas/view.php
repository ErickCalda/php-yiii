<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\ClasesProgramadas $model */

$estadoClass = match($model->estado){
    0 => 'progress',
    1 => 'active',
    2 => 'cancelled',
    default => 'progress'
};

$estadoTexto = match($model->estado){
    0 => 'En progreso',
    1 => 'Activo',
    2 => 'Cancelado',
    default => 'Desconocido'
};

?>

<div class="executive-page">

    <!-- TOP BAR -->
    <div class="topbar">

        <div class="title-block">
            <div class="eyebrow">GESTIÓN DE RESERVAS</div>
            <h1>Reserva #<?= $model->id ?></h1>
        </div>

        <div class="action-bar">

            <?= Html::a(
                'Editar',
                ['update', 'id' => $model->id],
                ['class' => 'action-btn primary']
            ) ?>

            <?= Html::a(
                'Eliminar',
                ['delete', 'id' => $model->id],
                [
                    'class' => 'action-btn danger',
                    'data-method' => 'post',
                    'data-confirm' => '¿Eliminar esta reserva?'
                ]
            ) ?>

        </div>

    </div>


    <!-- PANEL -->
    <div class="executive-card">

        <!-- HEADER -->
        <div class="card-header">

            <div class="user-block">

                <div class="user-initial">
                    <?= strtoupper(substr($model->usuarios->nombre ?? 'D',0,1)) ?>
                </div>

                <div>

                    <div class="user-name">
                        <?= $model->usuarios->nombre ?? 'Docente' ?>
                        <?= $model->usuarios->apellido ?? '' ?>
                    </div>

                    <div class="user-role">
                        Responsable de la reserva
                    </div>

                </div>

            </div>

            <div class="status-badge <?= $estadoClass ?>">
                <?= $estadoTexto ?>
            </div>

        </div>


        <!-- BODY -->
        <div class="info-grid">

            <div class="info-row">
                <label>Laboratorio</label>
                <div><?= $model->laboratorios->nombre ?? 'No asignado' ?></div>
            </div>

            <div class="info-row">
                <label>Materia</label>
                <div><?= $model->materias->nombre ?? 'No asignado' ?></div>
            </div>

            <div class="info-row">
                <label>Curso</label>
                <div><?= $model->cursos->nombre ?? 'No asignado' ?></div>
            </div>

            <div class="info-row">
                <label>Período Académico</label>
                <div><?= $model->periodosAcademicos->nombre ?? 'No asignado' ?></div>
            </div>

            <div class="info-row">
                <label>Día</label>
                <div><?= ucfirst($model->dia_semana) ?></div>
            </div>

            <div class="info-row">
                <label>Horario</label>
                <div><?= $model->hora_inicio ?> — <?= $model->hora_fin ?></div>
            </div>

        </div>

    </div>

</div>

<style>
<style>

/* ==========================================
   EXECUTIVE DESKTOP UI
========================================== */

:root{

    --bg:#EEF2F6;
    --surface:#FFFFFF;

    --navy:#1F2937;
    --navy-dark:#111827;

    --border:#D5DEE8;
    --border-strong:#BAC6D3;

    --text:#111827;
    --muted:#6B7280;

    --success-bg:#EDF7F0;
    --success-text:#355E3B;

    --warning-bg:#FFF6EA;
    --warning-text:#9A5B13;

    --danger-bg:#FDF0F2;
    --danger-text:#7A2438;

}


/* ==========================================
   PAGE
========================================== */

.executive-page{

    max-width:1400px;

    margin:auto;

    padding:24px;

    font-family:"Segoe UI", system-ui, sans-serif;

    color:var(--text);

}


/* ==========================================
   TOPBAR
========================================== */

.topbar{

    display:grid;

    grid-template-columns:1fr auto;

    gap:18px;

    align-items:end;

    margin-bottom:18px;

}


/* ==========================================
   TITLE
========================================== */

.eyebrow{

    display:inline-flex;

    align-items:center;

    height:24px;

    padding:0 10px;

    background:#E7ECF2;

    border:1px solid #D5DDE7;
    border-radius:4px;

    font-size:10px;
    font-weight:700;

    letter-spacing:.7px;

    color:#475569;

    text-transform:uppercase;

}

.title-block h1{

    margin:10px 0 0;

    font-size:32px;
    font-weight:700;

    color:var(--navy-dark);

    letter-spacing:-.5px;

}


/* ==========================================
   ACTION BAR
========================================== */

.action-bar{

    display:flex;

    align-items:center;

    gap:10px;

    flex-wrap:wrap;

}

.action-btn{

    text-decoration:none;

    display:inline-flex;

    align-items:center;
    justify-content:center;

    min-width:120px;

    height:40px;

    padding:0 18px;

    border-radius:5px;

    border:1px solid;

    font-size:12px;
    font-weight:700;

    letter-spacing:.3px;

    transition:.15s ease;

}


/* PRIMARY */

.action-btn.primary{

    background:#2F3A4A;

    border-color:#2F3A4A;

    color:#FFFFFF;

}

.action-btn.primary:hover{

    background:#1F2937;

}


/* DANGER */

.action-btn.danger{

    background:#6B2737;

    border-color:#6B2737;

    color:#FFFFFF;

}

.action-btn.danger:hover{

    background:#56202C;

}


/* ==========================================
   MAIN PANEL
========================================== */

.executive-card{

    background:var(--surface);

    border:1px solid var(--border-strong);

    border-radius:5px;

    overflow:hidden;

    box-shadow:
        0 1px 2px rgba(15,23,42,.04),
        0 8px 24px rgba(15,23,42,.04);

}


/* ==========================================
   HEADER
========================================== */

.card-header{

    display:flex;

    justify-content:space-between;

    align-items:center;

    gap:20px;

    padding:22px 24px;

    background:
        linear-gradient(
            to bottom,
            #FBFCFD,
            #F4F7FA
        );

    border-bottom:1px solid var(--border);

}


/* ==========================================
   USER
========================================== */

.user-block{

    display:flex;

    align-items:center;

    gap:16px;

}

.user-initial{

    width:54px;
    height:54px;

    flex-shrink:0;

    display:flex;

    align-items:center;
    justify-content:center;

    border-radius:5px;

    background:#1F2937;

    color:#FFFFFF;

    font-size:18px;
    font-weight:700;

    border:1px solid #111827;

    box-shadow:
        inset 0 1px 0 rgba(255,255,255,.08);

}

.user-name{

    font-size:18px;
    font-weight:700;

    color:#111827;

}

.user-role{

    margin-top:4px;

    font-size:12px;

    color:#6B7280;

}


/* ==========================================
   STATUS
========================================== */

.status-badge{

    display:inline-flex;

    align-items:center;
    justify-content:center;

    min-width:130px;

    height:36px;

    padding:0 14px;

    border-radius:4px;

    font-size:12px;
    font-weight:700;

    letter-spacing:.2px;

    border:1px solid transparent;

    white-space:nowrap;

}

.status-badge.progress{

    background:var(--warning-bg);
    color:var(--warning-text);

    border-color:#F3DFC2;

}

.status-badge.active{

    background:var(--success-bg);
    color:var(--success-text);

    border-color:#D5E7DA;

}

.status-badge.cancelled{

    background:var(--danger-bg);
    color:var(--danger-text);

    border-color:#F0D7DD;

}


/* ==========================================
   INFO GRID
========================================== */

.info-grid{

    display:grid;

    grid-template-columns:
        repeat(auto-fit, minmax(240px,1fr));

    gap:14px;

    padding:22px;

    background:#F7F9FC;

}


/* ==========================================
   INFO CARD
========================================== */

.info-row{

    background:#FFFFFF;

    border:1px solid #DCE4EC;

    border-radius:5px;

    padding:16px;

    min-height:92px;

    display:flex;

    flex-direction:column;

    justify-content:center;

    transition:.15s ease;

    box-shadow:
        inset 0 1px 0 rgba(255,255,255,.7);

}

.info-row:hover{

    border-color:#B9C6D4;

    transform:translateY(-1px);

}


/* ==========================================
   LABEL
========================================== */

.info-row label{

    display:flex;

    align-items:center;

    gap:6px;

    margin-bottom:8px;

    font-size:10px;
    font-weight:700;

    letter-spacing:.8px;

    text-transform:uppercase;

    color:#64748B;

}


/* ==========================================
   VALUE
========================================== */

.info-row div{

    font-size:15px;
    font-weight:700;

    color:#111827;

    line-height:1.4;

}


/* ==========================================
   RESPONSIVE
========================================== */

@media(max-width:900px){

    .topbar{

        grid-template-columns:1fr;

        align-items:flex-start;

    }

    .action-bar{

        width:100%;

    }

}


@media(max-width:640px){

    .executive-page{

        padding:12px;

    }

    .title-block h1{

        font-size:26px;

    }

    .action-bar{

        display:grid;

        grid-template-columns:1fr;

        width:100%;

    }

    .action-btn{

        width:100%;

    }

    .card-header{

        flex-direction:column;

        align-items:flex-start;

    }

    .status-badge{

        width:100%;

    }

    .info-grid{

        grid-template-columns:1fr;

        padding:14px;

    }

}


</style>