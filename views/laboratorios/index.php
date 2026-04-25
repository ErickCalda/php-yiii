<?php

use app\models\Laboratorios;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\models\LaboratoriosSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Laboratorios');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="laboratorios-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <p>
    <?= Html::a('Crear Laboratorio', ['create'], [
        'class' => 'btn btn-success'
    ]) ?>
</p>

    <?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        'nombre',
        'ubicacion',
        'descripcion:ntext',

        [
            'label' => 'Responsable',
            'value' => function ($model) {
                return $model->responsable
                    ? $model->responsable->nombre
                    : 'No asignado';
            },
            'filter' => \yii\helpers\ArrayHelper::map(
                \app\models\Usuarios::find()->all(),
                'id',
                function ($u) {
                    return $u->nombre . ' ' . $u->apellido;
                }
            ),
        ],

        [
            'class' => \yii\grid\ActionColumn::class,
            'header' => 'Acciones',
            'template' => '{menu}',

            'buttons' => [
                'menu' => function ($url, $model) {

                    if (
                        !Yii::$app->user->isGuest &&
                        Yii::$app->user->identity->rol_id == \app\models\Usuarios::ROL_ADMIN
                    ) {
                        return Html::a('<i class="bi bi-three-dots-vertical"></i>', 'javascript:void(0);', [
                            'class' => 'btn btn-sm btn-info menu-toggle',
                            'data-id' => $model->id,
                            'title' => 'Opciones',
                        ]);
                    }

                    return '';
                },
            ],
        ],
    ],
]); ?>

    <?php Pjax::end(); ?>

</div>

<!-- Menú desplegable -->
<div id="menu-container"></div>

<!-- Estilos CSS -->
<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

/* ===============================
   PALETA CONSISTENTE GLOBAL
=================================*/
:root{
    --bg:#F8FAFC;
    --surface:#FFFFFF;
    --text:#0F172A;
    --text-soft:#64748B;
    --line:#E2E8F0;
    --primary:#6366F1;
    --primary-hover:#4F46E5;
    --hover:#F8FAFC;
}

/* BASE */
body{
    background:var(--bg);
    font-family:'Inter',sans-serif;
    color:var(--text);
}

/* CONTENEDOR */
.laboratorios-index{
    max-width:1450px;
    margin:auto;
    padding:38px;
}

/* TITULO */
.laboratorios-index h1{
    font-size:34px;
    font-weight:700;
    letter-spacing:-1px;
    color:var(--text);
    margin-bottom:24px;
}

/* BOTÓN (si lo usas después) */
.btn-success{
    all:unset;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    padding:11px 18px;
    background:var(--primary);
    color:white;
    font-size:14px;
    font-weight:600;
    border-radius:10px;
    cursor:pointer;
    transition:.18s ease;
}

.btn-success:hover{
    background:var(--primary-hover);
    transform:translateY(-1px);
}

/* TABLA */
.grid-view{
    background:var(--surface);
    border:1px solid var(--line);
    border-radius:24px;
    overflow:hidden;
}

/* TABLE */
.grid-view table{
    width:100%;
    border-collapse:collapse;
}

/* HEADER */
.grid-view thead th{
    background:var(--surface);
    color:var(--text-soft);
    font-size:12px;
    text-transform:uppercase;
    letter-spacing:.08em;
    font-weight:700;
    padding:20px 24px;
    border-bottom:1px solid var(--line);
}

/* CELDAS */
.grid-view tbody td{
    background:var(--surface);
    padding:22px 24px;
    font-size:15px;
    font-weight:500;
    color:var(--text);
    border-bottom:1px solid #F1F5F9;
}

/* HOVER SUAVE */
.grid-view tbody tr{
    transition:.15s ease;
}

.grid-view tbody tr:hover td{
    background:var(--hover);
}

/* ULTIMA FILA */
.grid-view tbody tr:last-child td{
    border-bottom:none;
}

/* BOTÓN MENÚ */
.btn-info.menu-toggle{
    all:unset;
    width:34px;
    height:34px;
    border-radius:50%;
    display:flex;
    align-items:center;
    justify-content:center;
    cursor:pointer;
    color:var(--text-soft);
    transition:.18s ease;
}

.btn-info.menu-toggle:hover{
    background:#EEF2FF;
    color:var(--primary);
}

/* DROPDOWN */
.dropdown-menu{
    display:none;
    position:absolute;
    min-width:190px;
    background:white;
    border:1px solid var(--line);
    border-radius:18px;
    padding:8px;
    box-shadow:0 10px 30px rgba(15,23,42,.06);
    z-index:999;
}

.dropdown-menu.show{
    display:block;
}

/* LINKS MENU */
.dropdown-menu a{
    display:block;
    padding:12px 14px;
    border-radius:12px;
    text-decoration:none;
    color:var(--text);
    font-size:14px;
    font-weight:500;
    transition:.15s ease;
}

.dropdown-menu a:hover{
    background:#EEF2FF;
    color:var(--primary);
}

/* RESPONSIVE */
@media(max-width:768px){

.laboratorios-index{
    padding:20px;
}

.laboratorios-index h1{
    font-size:28px;
}

.grid-view thead th,
.grid-view tbody td{
    padding:16px;
    font-size:13px;
}

}
</style>

<!-- Script para el menú desplegable -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const menuButtons = document.querySelectorAll('.menu-toggle');

        menuButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                const id = button.getAttribute('data-id');
                const menuContainer = document.getElementById('menu-container');

                // Cerrar cualquier menú abierto previamente
                const openMenus = document.querySelectorAll('.dropdown-menu.show');
                openMenus.forEach(function (menu) {
                    menu.classList.remove('show');
                });

                // Crear el contenido del menú
                const menu = document.createElement('div');
                menu.classList.add('dropdown-menu');
                menu.setAttribute('id', 'menu-' + id);

                menu.innerHTML = `
                    <a href="<?= Url::to(['laboratorios/view', 'id' => '']) ?>${id}">Ver</a>
                    <a href="<?= Url::to(['laboratorios/update', 'id' => '']) ?>${id}">Editar</a>
                    <a href="javascript:void(0);" onclick="confirmDelete(${id})">Eliminar</a>
                `;

                // Insertar el menú en el contenedor
                menuContainer.appendChild(menu);

                // Mostrar el menú desplegable
                menu.classList.add('show');

                // Posicionar el menú debajo del botón
                const buttonRect = button.getBoundingClientRect();
                menu.style.top = `${buttonRect.bottom + window.scrollY + 5}px`;
                menu.style.left = `${buttonRect.left}px`;
            });
        });

        // Cerrar el menú al hacer clic fuera
        document.addEventListener('click', function (e) {
            if (!e.target.closest('.menu-toggle')) {
                const openMenus = document.querySelectorAll('.dropdown-menu.show');
                openMenus.forEach(function (menu) {
                    menu.classList.remove('show');
                });
            }
        });
    });

    // Función de confirmación de eliminación
    function confirmDelete(id) {
        if (confirm("¿Estás seguro de eliminar este laboratorio?")) {
            // Realiza la eliminación con el método POST
            window.location.href = "<?= Url::to(['laboratorios/delete', 'id' => '']) ?>" + id;
        }
    }
</script>
