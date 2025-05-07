<?php

use app\models\Bitacoras;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var app\models\BitacorasSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Bitacoras');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bitacoras-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Bitacoras'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <div class="search-box" style="margin-bottom: 20px;">
    <?= Html::beginForm(['bitacoras/index'], 'get') ?>
        <?= Html::input('text', 'BitacorasSearch[descripcion, fecha_registro]', Yii::$app->request->get('BitacorasSearch')['descripcion,fecha_registro'] ?? '', [
            'class' => 'form-control',
            'placeholder' => 'Buscar por descripción...',
            'style' => 'max-width: 300px; display: inline-block; margin-right: 10px;'
        ]) ?>
        <?= Html::submitButton('Buscar', ['class' => 'btn btn-primary']) ?>
    <?= Html::endForm() ?>
</div>

    <?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => null,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        [
            'label' => 'Reservado por',
            'attribute' => 'reserva_id',
            'value' => function ($model) {
                return $model->reserva && $model->reserva->usuario
                    ? $model->reserva->usuario->nombre
                    : 'No disponible';
            },
        ],
        'descripcion:ntext',
        
        'fecha_registro',
        [
            'class' => ActionColumn::className(),
            'urlCreator' => function ($action, Bitacoras $model, $key, $index, $column) {
                return Url::toRoute([$action, 'id' => $model->id]);
            },
            'header' => 'Acciones',
            'template' => '{menu}',
            'buttons' => [
                'menu' => function ($url, $model) {
                    return Html::a('<i class="bi bi-three-dots-vertical"></i>', 'javascript:void(0);', [
                        'class' => 'btn btn-sm btn-info menu-toggle',
                        'data-id' => $model->id,
                        'title' => 'Opciones',
                    ]);
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
    .bitacoras-index {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f4f4f4;
        padding: 30px;
        border-radius: 8px;
    }

    h1 {
        color: #2c3e50;
        font-weight: bold;
    }

    .btn-success {
        background-color: #3498db;
        color: white;
        border-radius: 5px;
        font-weight: bold;
    }

    .btn-success:hover {
        background-color: #2980b9;
    }

    .grid-view {
        background-color: #ffffff;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .grid-view th, .grid-view td {
        padding: 15px;
        text-align: left;
    }

    .grid-view th {
        background-color: #2c3e50;
        color: white;
        font-weight: bold;
    }

    .grid-view td {
        background-color: #ecf0f1;
    }

    .grid-view tr:hover {
        background-color: #e2e6ea;
    }

    .btn-sm {
        border-radius: 3px;
        padding: 5px 10px;
    }

    .btn-info {
        font-size: 16px;
        font-weight: bold;
    }

    .btn-info:hover {
        background-color: #2980b9;
    }

    /* Menú desplegable */
    .menu-toggle {
        cursor: pointer;
        display: inline-block;
    }

    .dropdown-menu {
        display: none;
        position: absolute;
        background-color: #ffffff;
        border: 1px solid #ddd;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        padding: 10px;
        border-radius: 5px;
        font-size: 14px;
    }

    .dropdown-menu a {
        color: #2c3e50;
        text-decoration: none;
        display: block;
        padding: 5px 10px;
        font-weight: bold;
    }

    .dropdown-menu a:hover {
        background-color: #f0f0f0;
        color: #2980b9;
    }

    /* Estilo cuando el menú está desplegado */
    .dropdown-menu.show {
        display: block;
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
                    <a href="<?= Url::to(['bitacoras/view', 'id' => '']) ?>${id}">Ver</a>
                    <a href="<?= Url::to(['bitacoras/update', 'id' => '']) ?>${id}">Editar</a>
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
        if (confirm("¿Estás seguro de eliminar esta bitácora?")) {
            // Realiza la eliminación con el método POST
            window.location.href = "<?= Url::to(['bitacoras/delete', 'id' => '']) ?>" + id;
        }
    }
</script>
