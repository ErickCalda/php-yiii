<?php

use app\models\Usuarios;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\models\UsuariosSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Usuarios');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="usuarios-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Crear Usuario'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'nombre',
            'apellido',
            'correo',
            'clave',
            [
                'class' => ActionColumn::className(),
                'template' => '{menu}',
                'buttons' => [
                    'menu' => function ($url, $model) {
                        return Html::button('<i class="bi bi-three-dots-vertical"></i>', [
                            'class' => 'btn btn-sm btn-info menu-toggle',
                            'data-id' => $model->id,
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
    .usuarios-index {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f9f9f9;
        padding: 5px;
        border-radius: 8px;
    }

    h1 {
        color: #2c3e50;
        font-weight: bold;
    }

    .btn-success {
        background-color: #3498db;
        border: none;
        font-weight: bold;
        border-radius: 5px;
    }

    .btn-success:hover {
        background-color: #2980b9;
    }

    .grid-view {
        background-color: #ffffff;
        border-radius: 8px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    }

    .grid-view th {
        background-color: #2c3e50;
        color: white;
        padding: 12px;
    }

    .grid-view td {
        background-color: #f4f4f4;
        padding: 12px;
    }

    .btn-info.menu-toggle {
        background-color: #2c3e50;
        color: white;
        font-weight: bold;
        border-radius: 4px;
        border: none;
    }

    .btn-info.menu-toggle:hover {
        background-color: #1a252f;
    }

    .dropdown-menu {
        display: none;
        position: absolute;
        background-color: #ffffff;
        border: 1px solid #ddd;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        border-radius: 5px;
        min-width: 140px;
        z-index: 999;
    }

    .dropdown-menu a {
        display: block;
        padding: 8px 15px;
        color: #2c3e50;
        text-decoration: none;
        font-weight: 500;
    }

    .dropdown-menu a:hover {
        background-color: #f1f1f1;
        color: #2980b9;
    }

    .dropdown-menu.show {
        display: block;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const menuButtons = document.querySelectorAll('.menu-toggle');

        menuButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                const id = this.dataset.id;
                const menuContainer = document.getElementById('menu-container');
                menuContainer.innerHTML = '';

                const menu = document.createElement('div');
                menu.classList.add('dropdown-menu');
                menu.setAttribute('id', 'dropdown-' + id);

                menu.innerHTML = `
                    <a href="<?= Url::to(['usuarios/view', 'id' => '']) ?>${id}">Ver</a>
                    <a href="<?= Url::to(['usuarios/update', 'id' => '']) ?>${id}">Editar</a>
                    <a href="javascript:void(0);" onclick="confirmDelete(${id})">Eliminar</a>
                `;

                menuContainer.appendChild(menu);

                const rect = button.getBoundingClientRect();
                menu.style.top = (rect.bottom + window.scrollY) + 'px';
                menu.style.left = (rect.left + window.scrollX) + 'px';

                menu.classList.add('show');
            });
        });

        document.addEventListener('click', function (e) {
            if (!e.target.closest('.menu-toggle') && !e.target.closest('.dropdown-menu')) {
                document.querySelectorAll('.dropdown-menu').forEach(m => m.classList.remove('show'));
            }
        });
    });

    function confirmDelete(id) {
        if (confirm("¿Estás seguro de que deseas eliminar este usuario?")) {
            window.location.href = "<?= Url::to(['usuarios/delete', 'id' => '']) ?>" + id;
        }
    }
</script>
