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
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <title><?= Html::encode($this->title) ?></title>
     <link rel="stylesheet" href="<?= Yii::getAlias('@web') ?>/css/main.css"> 
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <?php $this->head() ?>
</head>
<body class="d-flex">
<?php $this->beginBody() ?>


<nav id="sidebar" class="bg-dark text-white vh-100" style="width:250px; position:fixed; padding-top:20px; transition: width .2s ease;">

<div class="px-3 mb-4 d-flex justify-content-start align-items-center">
  <div class="d-flex align-items-center logo-container">
     <!-- Icono (solo visible cuando está contraído) -->
 

<!-- Título (solo visible cuando está desplegado) -->
<span class="ms-2 text-white fs-5 logo-title">GL</span>
  </div>
  <button id="toggleSidebar" class=" estylo  ms-2 d-flex align-items-center justify-content-center">
    <i class="bi bi-list"></i>
  </button>
</div>



<ul class="nav flex-column px-3">
    <!-- Home -->
    <!-- Home -->
<li class="nav-item mb-1">
    <a class="nav-link text-white d-flex align-items-center" href="<?= \yii\helpers\Url::to(['/site/index']) ?>">
        <i class="bi bi-house-door"></i>
        <span class="link-text ms-2">Home</span>
    </a>
</li>

<?php if (!Yii::$app->user->isGuest): ?>
    <!-- Bitacora -->
    <li class="nav-item mb-1">
        <a class="nav-link text-white d-flex align-items-center" href="<?= \yii\helpers\Url::to(['/bitacoras/index']) ?>">
            <i class="bi bi-file-earmark-person-fill"></i>
            <span class="link-text ms-2">Bitacora</span>
        </a>
    </li>

    <!-- Laboratorios -->
    <li class="nav-item mb-1">
        <a class="nav-link text-white d-flex align-items-center collapsed" data-bs-toggle="collapse" href="#collapseLaboratorios" role="button">
            <i class="bi bi-building"></i><span class="link-text ms-2">Laboratorios</span>
            <i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul class="collapse nav flex-column ms-3" id="collapseLaboratorios">
            <li class="nav-item">
                <a class="nav-link text-white d-flex align-items-center" href="<?= \yii\helpers\Url::to(['/laboratorios/index']) ?>">
                    <i class="bi bi-eye"></i><span class="link-text ms-2">Ver Laboratorios</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white d-flex align-items-center" href="<?= \yii\helpers\Url::to(['/laboratorios/create']) ?>">
                    <i class="bi bi-plus-circle"></i><span class="link-text ms-2">Crear Laboratorio</span>
                </a>
            </li>
        </ul>
    </li>

    <!-- Equipos -->
    <li class="nav-item mb-1">
        <a class="nav-link text-white d-flex align-items-center collapsed" data-bs-toggle="collapse" href="#collapseEquipos" role="button">
            <i class="bi bi-tools"></i><span class="link-text ms-2">Equipos</span>
            <i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul class="collapse nav flex-column ms-3" id="collapseEquipos">
            <li class="nav-item">
                <a class="nav-link text-white d-flex align-items-center" href="<?= \yii\helpers\Url::to(['/equipos/index']) ?>">
                    <i class="bi bi-eye"></i><span class="link-text ms-2">Ver Equipos</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white d-flex align-items-center" href="<?= \yii\helpers\Url::to(['/equipos/crear']) ?>">
                    <i class="bi bi-plus-circle"></i><span class="link-text ms-2">Crear Equipo</span>
                </a>
            </li>
        </ul>
    </li>

    <!-- Materiales -->
    <li class="nav-item mb-1">
        <a class="nav-link text-white d-flex align-items-center collapsed" data-bs-toggle="collapse" href="#collapseMateriales" role="button">
            <i class="bi bi-box"></i><span class="link-text ms-2">Materiales</span>
            <i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul class="collapse nav flex-column ms-3" id="collapseMateriales">
            <li class="nav-item">
                <a class="nav-link text-white d-flex align-items-center" href="<?= \yii\helpers\Url::to(['/materiales/index']) ?>">
                    <i class="bi bi-eye"></i><span class="link-text ms-2">Materiales</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white d-flex align-items-center" href="<?= \yii\helpers\Url::to(['/entradasmateriales/index']) ?>">
                    <i class="bi bi-eye"></i><span class="link-text ms-2">Materiales</span>
                </a>
            </li>
        </ul>
    </li>

    <!-- Reservas -->
    <li class="nav-item mb-1">
        <a class="nav-link text-white d-flex align-items-center collapsed" data-bs-toggle="collapse" href="#collapseReservas" role="button">
            <i class="bi bi-calendar"></i><span class="link-text ms-2">Reservas</span>
            <i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul class="collapse nav flex-column ms-3" id="collapseReservas">
            <li class="nav-item">
                <a class="nav-link text-white d-flex align-items-center" href="<?= \yii\helpers\Url::to(['/reservas/index']) ?>">
                    <i class="bi bi-plus-circle"></i><span class="link-text ms-2">Crear Reserva</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white d-flex align-items-center" href="<?= \yii\helpers\Url::to(['/reservas/horario']) ?>">
                    <i class="bi bi-calendar-week"></i><span class="link-text ms-2">Vista por Semana</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white d-flex align-items-center" href="<?= \yii\helpers\Url::to(['']) ?>">
                    <i class="bi bi-calendar-month"></i><span class="link-text ms-2">Vista por Mes</span>
                </a>
            </li>
        </ul>
    </li>

    <!-- Usuarios -->
    <li class="nav-item mb-1">
        <a class="nav-link text-white d-flex align-items-center collapsed" data-bs-toggle="collapse" href="#collapseUsuarios" role="button">
            <i class="bi bi-person-circle"></i><span class="link-text ms-2">Usuarios</span>
            <i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul class="collapse nav flex-column ms-3" id="collapseUsuarios">
            <li class="nav-item">
                <a class="nav-link text-white d-flex align-items-center" href="<?= \yii\helpers\Url::to(['/usuarios/index']) ?>">
                    <i class="bi bi-person-lines-fill"></i><span class="link-text ms-2">Gestión de Usuarios</span>
                </a>
            </li>
        </ul>
    </li>
<?php endif; ?>

<!-- Cuenta -->
<li class="nav-item mb-1">
    <a class="nav-link text-white d-flex align-items-center collapsed" data-bs-toggle="collapse" href="#collapseCuenta" role="button">
        <i class="bi bi-person-lock"></i><span class="link-text ms-2">Cuenta</span>
        <i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul class="collapse nav flex-column ms-3" id="collapseCuenta">
        <?php if (Yii::$app->user->isGuest): ?>
            <li class="nav-item">
                <a class="nav-link text-white d-flex align-items-center" href="<?= \yii\helpers\Url::to(['/site/login']) ?>">
                    <i class="bi bi-box-arrow-in-right"></i><span class="link-text ms-2">Login</span>
                </a>
            </li>
        <?php else: ?>
            <li class="nav-item">
                <a class="nav-link text-white d-flex align-items-center" href="<?= \yii\helpers\Url::to(['/site/logout']) ?>" data-method="post">
                    <i class="bi bi-box-arrow-right"></i>
                    <span class="link-text ms-2">Logout (<?= Yii::$app->user->identity->correo ?>)</span>
                </a>
            </li>
        <?php endif; ?>
    </ul>
</li>


</ul>

    


</nav>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const sidebar = document.getElementById("sidebar"); 
    const toggleBtn = document.getElementById("toggleSidebar");
    const mainContent = document.getElementById("main");

    function updateMainMargin() {
        if (!mainContent) return; // Evita el error si #main no existe
        if (sidebar.classList.contains('collapsed')) {
            mainContent.style.marginLeft = '80px';
        } else {
            mainContent.style.marginLeft = '250px';
        }
    }

    toggleBtn.addEventListener("click", () => {
        sidebar.classList.toggle("collapsed");
        updateMainMargin();
    });

    updateMainMargin(); // Llamar después de asegurar que todo existe
});
</script>


<!-- Main content -->
<main id="main" class="flex-grow-1 p-3" style="margin-left:250px;">
    <div class="container">
        <?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs'] ?? []]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>



<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
