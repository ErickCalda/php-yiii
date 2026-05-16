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
         <link rel="stylesheet" href="<?= Yii::getAlias('@web') ?>/css/laboratorio.css">
     <link rel="stylesheet" href="<?= Yii::getAlias('@web') ?>/css/toast.css">
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


<?php if (!Yii::$app->user->isGuest): ?>

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
            <i class="bi  bi-building"  style="color:#6366F1;"></i><span class="link-text ms-2">Laboratorio</span>
            
        </a>
        
    </li>



<!-- Clases Programadas -->
     <li class="nav-item">
            <a class="nav-link d-flex align-items-center"
               style="color:#6366F1;"
               href="<?= \yii\helpers\Url::to(['/clases-programadas/index']) ?>">

              <i class="bi bi-calendar3" style="color:#6366F1;"></i>
        <span class="link-text ms-2">Clases</span>
       
            </a>
        </li>


<?php
$isAdmin = !Yii::$app->user->isGuest 
    && Yii::$app->user->identity->rol->nombre === 'admin';
?>

<?php if ($isAdmin): ?>
    <!-- Usuarios -->
    <li class="nav-item mb-1">
        <a class="nav-link d-flex align-items-center"
           style="color:#6366F1;"
           href="<?= \yii\helpers\Url::to(['/usuarios/index']) ?>">

            <i class="bi bi-person-circle" style="color:#6366F1;"></i>
            <span class="link-text ms-2">Usuarios</span>

        </a>
    </li>
<?php endif; ?>
<?php endif; ?>

<?php if (Yii::$app->user->isGuest): ?>

    <!-- LOGIN -->
    <li class="nav-item mb-1">
        <a class="nav-link d-flex align-items-center"
           href="<?= \yii\helpers\Url::to(['/site/login']) ?>">

            <i class="bi bi-box-arrow-in-right"></i>
            <span class="link-text ms-2">Login</span>
        </a>
    </li>

<?php else: ?>

    <!-- LOGOUT -->
    <li class="nav-item mb-1">
        <a class="nav-link d-flex align-items-center"
           href="<?= \yii\helpers\Url::to(['/site/logout']) ?>"
           data-method="post">

            <i class="bi bi-box-arrow-right"></i>
            <span class="link-text ms-2">Logout</span>
        </a>
    </li>

<?php endif; ?>


</ul>

    <style>
        
    </style>


</nav>




<?php endif; ?>




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

<?php
$user = Yii::$app->user->identity;
$isAdmin = method_exists($user, 'isAdmin') ? $user->isAdmin() : ($user->rol->nombre === 'admin');
?>

<div class="user-topbar">

    <div class="user-dropdown" id="userDropdown">

        <!-- BOTÓN -->
        <div class="user-trigger">

            <div class="user-avatar">
                <?= strtoupper(substr($user->nombre ?? 'U', 0, 1)) ?>
            </div>

            <div class="user-meta">
                <span class="user-name">
                    <?= Html::encode($user->nombre ?? 'Usuario') ?>
                </span>

                <span class="user-role <?= $isAdmin ? 'admin' : '' ?>">
                    <?= $isAdmin ? 'Administrador' : 'Usuario' ?>
                </span>
            </div>

            <i class="bi bi-chevron-down dropdown-arrow"></i>
        </div>

        <!-- MENÚ -->
        <div class="user-menu">

            <!-- PERFIL REAL -->
            <a href="<?= \yii\helpers\Url::to(['/usuarios/perfil']) ?>" class="menu-item">
                <i class="bi bi-person"></i>
                <span>Mi perfil</span>
            </a>

            <!-- CONFIGURACIÓN (opcional futuro) -->
            <a href="#" class="menu-item">
                <i class="bi bi-gear"></i>
                <span>Configuración</span>
            </a>

            <div class="menu-divider"></div>

            <!-- LOGOUT -->
            <a href="<?= \yii\helpers\Url::to(['/site/logout']) ?>"
               data-method="post"
               class="menu-item danger">

                <i class="bi bi-box-arrow-right"></i>
                <span>Cerrar sesión</span>
            </a>

        </div>

    </div>

</div>

<?php endif; ?>
</main>










<!-- Añadir Google Fonts en el head -->
<?php $this->registerCss('
    @import url("https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap");

'); ?>



<script>
document.addEventListener("DOMContentLoaded", function(){

    const dropdown = document.getElementById("userDropdown");

    if(!dropdown) return;

    const trigger = dropdown.querySelector(".user-trigger");

    trigger.addEventListener("click", function(e){
        e.stopPropagation();
        dropdown.classList.toggle("open");
    });

    document.addEventListener("click", function(){
        dropdown.classList.remove("open");
    });

});
</script>


    <?php
$this->registerJsFile('https://cdn.jsdelivr.net/npm/sweetalert2@11', ['position' => \yii\web\View::POS_END]);
?>

<?php $this->endBody() ?>

 <div id="cursor-shadow"></div>



<script>
    window.toastFlash = <?= json_encode(Yii::$app->session->getFlash('toast', null)) ?>;
</script>

<script src="<?= Yii::getAlias('@web') ?>/js/toast.js"></script>



<div id="toast-container"></div>
</body>
</html>
<?php $this->endPage() ?>
