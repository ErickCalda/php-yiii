<?php
$this->title = 'Cambiar contraseña';
?>

<div class="saas-page">

    <div class="saas-card form">

        <!-- HEADER SUPERIOR (CON BACK) -->
        <div class="form-topbar">

            <a href="<?= \yii\helpers\Url::to(['/usuarios/perfil']) ?>" class="back-link">
                ← Volver al perfil
            </a>

            <div class="header">
                <h3 class="form-title">Actualizar contraseña</h3>
                <p class="form-subtitle">Ingrese su información para cambiar la contraseña</p>
            </div>

        </div>

        <!-- FORM -->
        <form method="post" class="form-body">

            <input type="hidden" name="_csrf" value="<?= Yii::$app->request->csrfToken ?>">

            <input type="password" name="actual" placeholder="Contraseña actual" class="input">
            <input type="password" name="nueva" placeholder="Nueva contraseña" class="input">
            <input type="password" name="confirmar" placeholder="Confirmar contraseña" class="input">

            <button class="btn-primary">
                Guardar cambios
            </button>

        </form>

    </div>

</div>





<style>

/* =========================
   PAGE
========================= */

.saas-page{
    display:flex;
    justify-content:center;
    align-items:flex-start;
    padding:40px 16px;
    min-height:70vh;
    background:#F8FAFC;
    font-family:'Inter', sans-serif;
}

/* =========================
   CARD
========================= */

.saas-card.form{
    width:100%;
    max-width:420px;
    background:#fff;
    border:1px solid #E2E8F0;
    border-radius:16px;
    padding:28px;
}

/* =========================
   TOP SECTION (BACK + TITLE)
========================= */

.form-topbar{
    margin-bottom:14px;
}

/* BACK LINK (INTEGRADO) */
.back-link{
    display:inline-block;
    font-size:13px;
    color:#64748B;
    text-decoration:none;
    font-weight:500;
    margin-bottom:10px;
}

/* sin efectos fuertes */
.back-link:hover{
    color:#0F172A;
}

/* =========================
   HEADER TEXT
========================= */

.header{
    margin-bottom:6px;
}

.form-title{
    font-size:18px;
    font-weight:600;
    color:#0F172A;
    margin:0;
}

.form-subtitle{
    font-size:13px;
    color:#64748B;
    margin-top:4px;
}

/* =========================
   FORM
========================= */

.form-body{
    margin-top:14px;
    display:flex;
    flex-direction:column;
    gap:12px;
}

/* INPUTS */
.input{
    width:100%;
    padding:12px 14px;
    border:1px solid #E2E8F0;
    border-radius:10px;
    font-size:14px;
    background:#fff;
    outline:none;
}

.input:focus{
    border-color:#6366F1;
}

/* =========================
   BUTTON
========================= */

.btn-primary{
    width:100%;
    padding:12px;
    background:#6366F1;
    color:#fff;
    border-radius:10px;
    font-weight:600;
    border:none;
    cursor:pointer;
}

.btn-primary:hover{
    background:#4F46E5;
}

/* =========================
   RESPONSIVE
========================= */

@media (max-width:480px){
    .saas-card.form{
        padding:20px;
        border-radius:14px;
    }

    .form-title{
        font-size:16px;
    }
}
</style>