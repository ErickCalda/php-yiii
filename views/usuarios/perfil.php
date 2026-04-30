<?php
use yii\helpers\Html;

$this->title = 'Mi Perfil';
$user = $model;
?>

<div class="saas-page">

    <div class="saas-card profile">

        <!-- CERRAR / SALIR -->
<a href="<?= \yii\helpers\Url::to(['/site/index']) ?>" class="close-btn" aria-label="Cerrar perfil">
    <i class="bi bi-x-lg"></i>
</a>

        <div class="avatar">
            <?= strtoupper(substr($user->nombre, 0, 1)) ?>
        </div>

        <h2 class="title">
            <?= Html::encode($user->nombre . ' ' . $user->apellido) ?>
        </h2>

        <span class="badge-role">
            <?= Html::encode($user->rol->nombre ?? 'Sin rol') ?>
        </span>

        <div class="info">
            <div><span>Correo</span><b><?= Html::encode($user->correo) ?></b></div>
            <div><span>Estado</span><b><?= Html::encode($user->estado) ?></b></div>
        </div>

        <a href="<?= \yii\helpers\Url::to(['/usuarios/cambiar-password']) ?>"
           class="btn-primary">
            Cambiar contraseña
        </a>

    </div>

</div>


<style>



/* PAGE */
.saas-page{
    display:flex;
    justify-content:center;
    align-items:flex-start;
    padding:50px 20px;
    min-height:70vh;
    background:#F8FAFC;
    font-family:'Inter', sans-serif;
}

/* CARD */
.saas-card.profile{
    position:relative;
    width:420px;
    background:#fff;
    border:1px solid #E2E8F0;
    border-radius:20px;
    padding:32px;
}

/* CLOSE BUTTON (SERIO Y LIMPIO) */

/* BOTÓN CERRAR PROFESIONAL */
.close-btn{
    position:absolute;
    top:14px;
    right:14px;

    width:32px;
    height:32px;

    display:flex;
    align-items:center;
    justify-content:center;

    border:1px solid #E2E8F0;
    border-radius:10px;

    background:#fff;
    color:#64748B;

    text-decoration:none;
    font-size:14px;
}

/* estado hover mínimo (sin efectos llamativos) */
.close-btn:hover{
    color:red;
    border-color:red;
}
/* AVATAR */
.avatar{
    width:76px;
    height:76px;
    border-radius:50%;
    background:#6366F1;
    color:#fff;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:26px;
    font-weight:700;
    margin:0 auto 16px;
}

/* TITULO */
.title{
    font-size:20px;
    font-weight:700;
    text-align:center;
    margin-bottom:8px;
}

/* BADGE */
.badge-role{
    display:inline-block;
    background:#EEF2FF;
    color:#6366F1;
    font-size:12px;
    padding:5px 10px;
    border-radius:999px;
    font-weight:600;
    margin-bottom:18px;
}

/* INFO */
.info{
    margin-top:18px;
    border-top:1px solid #E2E8F0;
}

.info div{
    display:flex;
    justify-content:space-between;
    padding:12px 0;
    border-bottom:1px solid #F1F5F9;
    font-size:14px;
}

.info span{
    color:#64748B;
}

.info b{
    color:#0F172A;
}

/* BUTTON */
.btn-primary{
    display:block;
    margin-top:20px;
    width:100%;
    padding:12px;
    background:#6366F1;
    color:#fff;
    text-align:center;
    border-radius:12px;
    font-weight:600;
    text-decoration:none;
}

.btn-primary:hover{
    background:#4F46E5;
}
</style>