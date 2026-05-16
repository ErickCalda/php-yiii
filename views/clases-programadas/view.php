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

.executive-page{
    max-width:1100px;
    margin:auto;
    padding:28px;
    font-family:"Segoe UI", system-ui, sans-serif;
    color:#111827;
}

/* =========================
   TOP BAR
========================= */
.topbar{
    display:flex;
    justify-content:space-between;
    align-items:flex-end;
    gap:20px;

    margin-bottom:24px;
    padding-bottom:18px;

    border-bottom:1px solid #D9E0E8;
}

.eyebrow{
    font-size:11px;
    font-weight:700;
    letter-spacing:1px;
    color:#6B7280;
    text-transform:uppercase;
}

.title-block h1{
    margin:6px 0 0;
    font-size:28px;
    font-weight:700;
    color:#111827;
}

/* =========================
   ACTIONS
========================= */
.action-bar{
    display:flex;
    gap:10px;
}

.action-btn{
    text-decoration:none;

    display:inline-flex;
    align-items:center;
    justify-content:center;

    min-width:110px;

    padding:10px 18px;

    font-size:13px;
    font-weight:600;
    letter-spacing:.2px;

    border-radius:5px;
    border:1px solid;

    cursor:pointer;
    transition:all .18s ease;
}

/* EDIT */
.action-btn.primary{
    background:#2F3A4A;
    border-color:#2F3A4A;
    color:#FFFFFF;
}

.action-btn.primary:hover{
    background:#202833;
    border-color:#202833;
}

/* DELETE */
.action-btn.danger{
    background:#6B2737;
    border-color:#6B2737;
    color:#FFFFFF;
}

.action-btn.danger:hover{
    background:#54202B;
    border-color:#54202B;
}

/* =========================
   MAIN CARD
========================= */
.executive-card{
    background:#FFFFFF;

    border:1px solid #D6DCE5;
    border-radius:5px;

    overflow:hidden;
}

/* =========================
   HEADER
========================= */
.card-header{

    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:20px;

    padding:22px;

    border-bottom:1px solid #E5EAF1;
}

.user-block{
    display:flex;
    align-items:center;
    gap:14px;
}

.user-initial{
    width:48px;
    height:48px;

    display:flex;
    align-items:center;
    justify-content:center;

    border-radius:5px;

    background:#1F2937;
    color:#FFFFFF;

    font-size:16px;
    font-weight:700;
}

.user-name{
    font-size:17px;
    font-weight:700;
    color:#111827;
}

.user-role{
    margin-top:2px;
    font-size:12px;
    color:#6B7280;
}

/* =========================
   STATUS
========================= */
.status-badge{

    flex:0 0 auto;

    min-width:120px;

    display:inline-flex;
    align-items:center;
    justify-content:center;

    white-space:nowrap;
    text-align:center;

    padding:8px 14px;

    border-radius:4px;

    font-size:12px;
    font-weight:700;
    letter-spacing:.2px;
}

.status-badge.progress{
    background:#F7F4EE;
    color:#8B5E34;
}

.status-badge.active{
    background:#F2F7F3;
    color:#355E3B;
}

.status-badge.cancelled{
    background:#F8F3F4;
    color:#6B2C3E;
}

/* =========================
   INFO GRID
========================= */
.info-grid{
    display:grid;
    grid-template-columns:repeat(2,1fr);
}

.info-row{
    padding:20px 22px;

    border-bottom:1px solid #EEF2F7;
}

.info-row:nth-child(odd){
    border-right:1px solid #EEF2F7;
}

.info-row label{
    display:block;

    margin-bottom:6px;

    font-size:11px;
    font-weight:700;
    letter-spacing:.6px;
    text-transform:uppercase;

    color:#6B7280;
}

.info-row div{
    font-size:15px;
    font-weight:600;
    color:#111827;
}

/* =========================
   RESPONSIVE
========================= */
@media(max-width:768px){

    .topbar{
        flex-direction:column;
        align-items:flex-start;
    }

    .action-bar{
        width:100%;
    }

    .action-btn{
        flex:1;
    }

    .card-header{
        flex-direction:column;
        align-items:flex-start;
    }

    .status-badge{
        margin-top:8px;
    }

    .info-grid{
        grid-template-columns:1fr;
    }

    .info-row:nth-child(odd){
        border-right:none;
    }

}

</style>