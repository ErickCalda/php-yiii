<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" >
<head>
    <title><?= Html::encode($this->title) ?></title>
     <link rel="stylesheet" href="<?= Yii::getAlias('@web') ?>/css/main.css">
      <link rel="stylesheet" href="<?= Yii::getAlias('@web') ?>/css/bitacora.css">
     <!-- Agregar Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
 
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    
    <?php $this->registerJsFile(Yii::getAlias('@web') . '/js/bitacora.js',['depends' => [\yii\web\JqueryAsset::class]]);?>

    <?php $this->registerJsFile(Yii::getAlias('@web') . '/js/main.js',['depends' => [\yii\web\JqueryAsset::class]]);?>


    <?php $this->head() ?>




</head>

<body class="d-flex" style="background-color: #e0dfdc ;">

<?php $this->beginBody() ?>


<nav id="sidebar" class=" text-white " style="width:250px; position:fixed; padding-top:20px; transition: width .2s ease; z-index: 9999;">

<div class="px-3 mb-4 d-flex justify-content-start align-items-center">
  <div class="d-flex align-items-center logo-container">
     <!-- Icono (solo visible cuando está contraído) -->
 


  </div>
  
</div>



<ul class="nav flex-column px-2">
    <!-- Home -->

<button id="toggleSidebar" class=" estylo   d-flex align-items-center justify-content-center">
    <i class=" bi-list" id="menu" style="color:#6366F1;"></i>
  </button>

    <li class="nav-item mb-1">
    
</li>



    <!-- Home -->
<li class="nav-item mb-1">
    <a class="nav-link  d-flex align-items-center" style="color:#6366F1;" href="<?= \yii\helpers\Url::to(['/site/index']) ?>">
        <i class="bi  bi-house-door" style="color:#6366F1;"></i>
        <span class="link-text ms-2">Home</span>
    </a>
</li>

<?php if (!Yii::$app->user->isGuest): ?>
    <!-- Bitacora -->
    <li class="nav-item mb-1">
        <a class="nav-link  d-flex align-items-center" style="color:#6366F1;"href="<?= \yii\helpers\Url::to(['/bitacoras/index']) ?>">
            <i class="bi  bi-file-earmark-person-fill"  style="color:#6366F1;"></i>
            <span class="link-text ms-2">Bitacora</span>
        </a>
    </li>

    <!-- Laboratorios -->
    <li class="nav-item mb-1">
        <a class="nav-link  d-flex align-items-center collapsed"style="color:#6366F1;" data-bs-toggle="" href="<?= \yii\helpers\Url::to(['/laboratorios/index']) ?>" role="button">
            <i class="bi  bi-building"  style="color:#6366F1;"></i><span class="link-text ms-2">G.Laboratorio</span>
            
        </a>
        
    </li>

    <!-- Equipos -->
    <li class="nav-item mb-1">
        <a class="nav-link d-flex align-items-center collapsed" style="color:#6366F1;" data-bs-toggle=""  href="<?= \yii\helpers\Url::to(['/equipos/index']) ?>" role="button">
            <i class="bi  bi-tools"  style="color:#6366F1;"></i><span class="link-text ms-2">G.Equipos</span>
          
        </a>
       
    </li>

    <!-- Materiales -->
    <li class="nav-item mb-1">
        <a class="nav-link  d-flex align-items-center collapsed" style="color:#6366F1;"data-bs-toggle="" href="<?= \yii\helpers\Url::to(['/materiales/index']) ?>" role="button">
            <i class="bi  bi-box"  style="color:#6366F1;"></i><span class="link-text ms-2">G.Materiales</span>
           
        </a>
        
    </li>

    <!-- Reservas -->
    <li class="nav-item mb-1">
        <a class="nav-link  d-flex align-items-center collapsed" style="color:#6366F1;" data-bs-toggle="collapse" href="#collapseReservas" role="button">
            <i class="bi  bi-calendar"  style="color:#6366F1;"></i><span class="link-text ms-2">Reservas</span>
            <i class="bi  bi-chevron-down ms-auto"  style="color:#6366F1;"></i>
        </a>
        <ul class="collapse nav flex-column ms-3" id="collapseReservas">
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center" style="color:#6366F1;" href="<?= \yii\helpers\Url::to(['/reservas/index']) ?>">
                    <i class="bi  bi-plus-circle"  style="color:#6366F1;"></i><span class="link-text ms-2">G.Reservas</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center"style="color:#6366F1;" href="<?= \yii\helpers\Url::to(['/reservas/horario']) ?>">
                    <i class="bi  bi-calendar-week"  style="color:#6366F1;"></i><span class="link-text ms-2">Horario</span>
                </a>
            </li>
           
        </ul>
    </li>

    <!-- Usuarios -->
    <li class="nav-item mb-1">
        <a class="nav-link  d-flex align-items-center "  style="color:#6366F1;"data-bs-toggle="" href="<?= \yii\helpers\Url::to(['/usuarios/index']) ?>"role="button">
            <i class="bi  bi-person-circle"  style="color:#6366F1;"></i><span class="link-text ms-2">G. de Usuarios</span>
           
        </a>
        
    </li>
<?php endif; ?>

<!-- Cuenta -->
<li class="nav-item mb-1">
    <a class="nav-link  d-flex align-items-center collapsed" style="color:#6366F1;" data-bs-toggle="collapse" href="#collapseCuenta" role="button">
        <i class="bi  bi-person-lock"  style="color:#6366F1;"></i><span class="link-text ms-2">Cuenta</span>
        <i class="bi  bi-chevron-down ms-auto"  style="color:#6366F1;"></i>
    </a>
    <ul class="collapse nav flex-column ms-3" id="collapseCuenta">
        <?php if (Yii::$app->user->isGuest): ?>
            <li class="nav-item">
                <a class="nav-link  d-flex align-items-center" style="color:#6366F1;" href="<?= \yii\helpers\Url::to(['/site/login']) ?>">
                    <i class="bi  bi-box-arrow-in-right"  style="color:#6366F1;"></i><span class="link-text ms-2" >Login</span>
                </a>
            </li>
        <?php else: ?>
            <li class="nav-item">
                <a class="nav-link text-white d-flex align-items-center" style="color:#6366F1;" href="<?= \yii\helpers\Url::to(['/site/logout']) ?>" data-method="post">
                    <i class="bi  bi-box-arrow-right"  style="color:#6366F1;"></i>
                    <span class="link-text   ms-2" style="color:#6366F1;">Logout
                </a>
            </li>
        <?php endif; ?>
    </ul>
</li>


</ul>

    <style>
        
    </style>


</nav>

<style>

    #cursor-shadow{
    position: fixed;
    width: 60px;
    height: 60px;
    border-radius: 50%;
    pointer-events: none;

    z-index: 2147483647;

    background: rgba(99, 102, 241, 0.12);
    filter: blur(18px);

    transform: translate(-50%, -50%);
}


</style>
<script>

</script>



<main id="main" class="flex-grow-1 p-1 position-relative">
    <div class="contenedor">
        <?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs'] ?? []]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>

<!-- Sección del usuario en la parte superior derecha -->
<?php if (!Yii::$app->user->isGuest): ?>
    <div class="user-info position-absolute text-white" style="top: 10px; right: 20px; font-family: 'Roboto', sans-serif;">
        <i class="bi bi-person-circle" style="font-size: 24px;"></i>

        <span style="font-size: 24px; margin-left: 8px;">
            <?= Html::encode(Yii::$app->user->identity->nombre ?? 'Usuario desconocido') ?>

            <?php if (!Yii::$app->user->isGuest && Yii::$app->user->identity->isAdmin()): ?>
                <span class="badge bg-danger" style="margin-left: 10px; font-size: 12px; font-weight: 500; padding: 2px 8px;">
                    Administrador
                </span>
            <?php else: ?>
                <span class="badge bg-secondary" style="margin-left: 10px; font-size: 12px; font-weight: 500; padding: 2px 8px;">
                    Usuario
                </span>
            <?php endif; ?>
        </span>
    </div>
<?php endif; ?>
</main>

<!-- Añadir Google Fonts en el head -->
<?php $this->registerCss('
    @import url("https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap");

'); ?>






    <?php
$this->registerJsFile('https://cdn.jsdelivr.net/npm/sweetalert2@11', ['position' => \yii\web\View::POS_END]);
?>

<?php $this->endBody() ?>

 <div id="cursor-shadow"></div>
</body>
</html>
<?php $this->endPage() ?>
