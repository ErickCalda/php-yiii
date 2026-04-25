<?php

use app\models\Materiales;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\models\MaterialesSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */


$this->title = Yii::t('app', 'Materiales');
$this->params['breadcrumbs'][] = $this->title;
$isAdmin = !Yii::$app->user->isGuest
    && Yii::$app->user->identity->rol_id  === \app\models\Usuarios::ROL_ADMIN;

?>
<div class="materiales-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if ($isAdmin): ?>
        <p>
            <?= Html::a(Yii::t('app', 'Crear Material'), ['create'], ['class' => 'btn btn-success']) ?>
        </p>
    <?php endif; ?>

    <?php Pjax::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => null,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'nombre',
            'unidad_medida',
            'cantidad',
            [
                'attribute' => 'laboratorio_id',
                'value' => 'laboratorio.nombre',
                'label' => 'Laboratorio'
            ],
            [
                'class' => ActionColumn::className(),
                'template' => '{menu}',
                'buttons' => [
                    'menu' => function ($url, $model) use ($isAdmin) {
                        return Html::button('<i class="bi bi-three-dots-vertical"></i>', [
                            'class' => 'btn btn-sm btn-info menu-toggle',
                            'data-id' => $model->id,
                            'data-is-admin' => $isAdmin ? '1' : '0',
                        ]);
                    }
                ],
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>

<div id="menu-container"></div>

<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

/* ===============================
   PALETA ORIGINAL QUE TE GUSTÓ
   Slate + Indigo + White
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
.materiales-index{
    max-width:1450px;
    margin:auto;
    padding:38px;
}

/* TITULO */
.materiales-index h1{
    font-size:34px;
    font-weight:700;
    letter-spacing:-1px;
    color:var(--text);
    margin-bottom:24px;
}

/* BOTON CREAR */
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

/* TARJETA TABLA */
.grid-view{
    background:var(--surface);
    border:1px solid var(--line);
    border-radius:24px;
    overflow:hidden;
}

/* TABLA */
.grid-view table{
    width:100%;
    border-collapse:collapse;
    margin:0;
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

/* HOVER FILA */
.grid-view tbody tr{
    transition:.15s ease;
}

.grid-view tbody tr:hover td{
    background:var(--hover);
}

/* ÚLTIMA FILA */
.grid-view tbody tr:last-child td{
    border-bottom:none;
}

/* BOTON MENU */
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

/* MENU */
.dropdown-menu{
    display:none;
    position:absolute;
    min-width:190px;
    background:white;
    border:1px solid var(--line);
    border-radius:18px;
    padding:8px;
    box-shadow:
        0 10px 30px rgba(15,23,42,.06);
    z-index:999;
}

.dropdown-menu.show{
    display:block;
}

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

/* PAGINACION */
.pagination{
    margin-top:28px;
    gap:8px;
}

.pagination li{
    display:inline-block;
}

.pagination li a,
.pagination li span{
    all:unset;
    width:36px;
    height:36px;
    display:flex;
    align-items:center;
    justify-content:center;
    border-radius:50%;
    cursor:pointer;
    color:var(--text-soft);
    font-size:14px;
    transition:.15s ease;
}

.pagination li a:hover{
    background:white;
    box-shadow:0 4px 14px rgba(15,23,42,.05);
}

.pagination .active a{
    background:var(--primary) !important;
    color:white !important;
}

/* LINKS GENERALES */
a{
    text-decoration:none;
}

/* RESPONSIVE */
@media(max-width:768px){

.materiales-index{
    padding:20px;
}

.materiales-index h1{
    font-size:28px;
}

.grid-view thead th,
.grid-view tbody td{
    padding:16px;
    font-size:13px;
}

}
</style>

<script>
 

document.addEventListener('DOMContentLoaded', function () {

    let activeMenu = null;
    let activeButton = null;

    document.querySelectorAll('.menu-toggle').forEach(button => {

        button.addEventListener('click', function (e) {
            e.stopPropagation();

            const id = this.dataset.id;

            // 🔥 SI HACES CLICK EN EL MISMO BOTÓN → CERRAR
            if (activeButton === this) {
                closeMenu();
                return;
            }

            // 🔥 SI HAY OTRO MENÚ ABIERTO → CERRARLO
            closeMenu();

            activeButton = this;

            const menu = document.createElement('div');
            menu.className = 'dropdown-menu show';

            let html = `
                <a href="<?= Url::to(['usuarios/view', 'id' => '']) ?>${id}">Ver</a>
            `;

            if (<?= $isAdmin ? 'true' : 'false' ?>) {
                html += `
                    <a href="<?= Url::to(['usuarios/update', 'id' => '']) ?>${id}">Editar</a>
                    <a href="javascript:void(0);" onclick="confirmDelete(${id})">Eliminar</a>
                `;
            }

            menu.innerHTML = html;
            document.body.appendChild(menu);

            activeMenu = menu;

            const rect = this.getBoundingClientRect();

            let top = rect.bottom + 8;
            let left = rect.right - 180;

            // 🔥 DETECTAR BORDE DERECHO
            const menuWidth = 180;
            const screenWidth = window.innerWidth;

            if (left + menuWidth > screenWidth) {
                left = screenWidth - menuWidth - 10;
            }

            menu.style.top = `${top}px`;
            menu.style.left = `${left}px`;
        });
    });

    // 🔥 CERRAR AL HACER CLICK FUERA
    document.addEventListener('click', function () {
        closeMenu();
    });

    // 🔥 CERRAR AL HACER SCROLL
    window.addEventListener('scroll', function () {
        closeMenu();
    }, true);

    function closeMenu() {
        if (activeMenu) {
            activeMenu.remove();
            activeMenu = null;
            activeButton = null;
        }
    }
});


    function confirmDelete(id) {
        if (confirm("¿Estás seguro de que deseas eliminar este material?")) {
            window.location.href = "<?= Url::to(['materiales/delete', 'id' => '']) ?>" + id;
        }
    }
</script>
