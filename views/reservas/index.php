<?php

use app\models\Reservas;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\models\ReservasSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
 
$this->title = Yii::t('app', 'Reservas');
$this->params['breadcrumbs'][] = $this->title;

$isAdmin = !Yii::$app->user->isGuest && Yii::$app->user->identity->rol === \app\models\Usuarios::ROL_ADMIN;

?>

<div class="reservas-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if ($isAdmin): ?>
        <p>
            <?= Html::a(Yii::t('app', '<i class="fas fa-plus"></i> '), ['create'], ['class' => 'btn btn-success']) ?>
        </p>
    <?php endif; ?>

    <?php Pjax::begin(); ?>

    <div class="mb-4">
    <?php $form = \yii\widgets\ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => ['data-pjax' => 1, 'class' => 'form-inline'],
    ]); ?>

    <div class="form-group me-2">
        <?= $form->field($searchModel, 'globalSearch')->textInput([
            'placeholder' => 'Buscar por cualquier campo...',
            'class' => 'form-control',
        ])->label(false) ?>
    </div>

    <div class="form-group me-2">
        <?= Html::submitButton('Buscar', ['class' => 'btn btn-primary']) ?>
    </div>

    <?= Html::a('Limpiar', ['index'], ['class' => 'btn btn-outline-secondary']) ?>

    <?php \yii\widgets\ActiveForm::end(); ?>
    </div>
            <div class="table-scroll position-relative">
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => null, // Ya no es necesario este filtro ya que se maneja a través del `globalSearch`
                        'pager' => ['class' => 'yii\widgets\LinkPager', 'options' => ['style' => 'display:none;']],
                        'summary' => '', // Oculta resumen tipo "Mostrando 1-10 de X"
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            'laboratorio_id',
                            [
                                'label' => 'Usuario',
                                'attribute' => 'usuario_id',
                                'value' => function ($model) {
                                    return $model->usuario ? $model->usuario->nombre : 'No disponible';
                                },
                            ],
                            'fecha',
                            'hora_inicio',
                            'hora_fin',
                            [
                                'class' => ActionColumn::className(),
                                'template' => '{menu} {delete}', // Añadimos el botón de eliminar
                                'buttons' => [
                                    'menu' => function ($url, $model) use ($isAdmin) {
                                        return Html::button('<i class="bi bi-three-dots-vertical"></i>', [
                                            'class' => 'btn btn-sm btn-info menu-toggle',
                                            'data-id' => $model->id,
                                            'data-is-admin' => $isAdmin ? '1' : '0',
                                        ]);
                                    },
                                    'delete' => function ($url, $model) use ($isAdmin) {
                                                if (!$isAdmin) return ''; // Solo admin puede ver este botón
                                                return Html::a('<i class="bi bi-trash"></i>', '#', [
                                                    'class' => 'btn btn-sm btn-danger',
                                                    'onclick' => "confirmDelete({$model->id})",
                                                    'title' => 'Eliminar',
                                                ]);
                                            },
                                ],
                            ],
                        ],
                    ]); ?>
        </div>

    <?php Pjax::end(); ?>

</div>



<div id="menu-container"></div>

<style>
    .reservas-index {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f9f9f9;
        padding: 30px;
        border-radius: 8px;
        z-index: 9;
        
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

    .table-scroll {
        max-height: 500px; /* Altura máxima para scroll vertical */
        overflow-y: auto;
        overflow-x: auto;
        border-radius: 8px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    }

    .grid-view {
        background-color: #ffffff;
        min-width: 1000px;
    }

    .grid-view th {
        background-color: #2c3e50;
        color: white;
        padding: 12px;
        position: sticky;
        top: 0;
        z-index: 2;
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
        min-width: 14px;
        
        z-index: 999;
        margin-right:10px ;
    }
    .dropdown-menu {
        
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

    .table-scroll::-webkit-scrollbar {
    width: 10px;
    height: 10px;
}

.table-scroll::-webkit-scrollbar-track {
    background: #ecf0f1;
    border-radius: 10px;
}

.table-scroll::-webkit-scrollbar-thumb {
    background-color: #34495e;
    border-radius: 10px;
    border: 2px solid #ecf0f1;
}

.table-scroll::-webkit-scrollbar-thumb:hover {
    background-color: #2c3e50;
}

.form-inline .form-control {
    min-width: 200px;
}

.btn-primary {
    background-color: #2980b9;
    border: none;
}

.btn-primary:hover {
    background-color: #1c5986;
}
.table-scroll {
   
    position: relative; /* Esto a veces causa conflictos */
}

.swal2-popup-fixed-center {
    top: 50% !important;
    left: 50% !important;
    transform: translate(-50%, -50%) !important;
    position: top !important;
    margin: 0 !important;
}




.table-scroll {
    max-height: 500px; /* Altura máxima para scroll vertical */
    overflow-y: auto;
    overflow-x: auto;
    border-radius: 8px;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    width: 100%; /* Asegura que la tabla ocupe todo el ancho del contenedor */
    display: block; /* Esto es importante para habilitar el scroll horizontal */
}

.table-scroll table {
    width: 100%; /* Asegura que la tabla ocupe todo el ancho disponible */
    table-layout: auto; /* Hace que las columnas se ajusten al contenido */
}

.grid-view th, .grid-view td {
    white-space: nowrap; /* Previene el ajuste de texto dentro de las celdas */
}

@media (max-width: 767px) {
    .table-scroll {
        max-height: 400px; /* Reducir la altura para pantallas más pequeñas */
    }

    .table-scroll table {
        width: 100%; /* Asegura que la tabla se ajuste al 100% del contenedor */
    }

    .grid-view th, .grid-view td {
        padding: 8px; /* Reducir el padding para pantallas más pequeñas */
        font-size: 12px; /* Reducir el tamaño de la fuente */
    }

    .form-inline .form-control {
        min-width: 150px; /* Ajustar el tamaño de los inputs en pantallas pequeñas */
    }

    .btn-primary, .btn-success {
        font-size: 12px; /* Reducir el tamaño de los botones */
    }
}

@media (max-width: 480px) {
    .grid-view th, .grid-view td {
        font-size: 10px; /* Reducir más el tamaño de la fuente para pantallas muy pequeñas */
        padding: 6px; /* Reducir el padding aún más */
    }

    .form-inline .form-control {
        min-width: 120px; /* Ajustar el tamaño de los inputs aún más para pantallas muy pequeñas */
    }

    .btn-primary, .btn-success {
        font-size: 10px; /* Reducir el tamaño de los botones para pantallas más pequeñas */
    }
}


</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const menuButtons = document.querySelectorAll('.menu-toggle');

        menuButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                const id = this.dataset.id;
                const isAdmin = this.dataset.isAdmin === '1';
                const menuContainer = document.getElementById('menu-container');
                menuContainer.innerHTML = '';

                const menu = document.createElement('div');
                menu.classList.add('dropdown-menu');
                menu.setAttribute('id', 'dropdown-' + id);

                let html = `<a href="<?= Url::to(['reservas/view', 'id' => '']) ?>${id}">Ver</a>`;

                if (isAdmin) {
                    html += `
                        <a href="<?= Url::to(['reservas/update', 'id' => '']) ?>${id}">Editar</a>
                        <a href="javascript:void(0);" onclick="confirmDelete(${id})">Eliminar</a>
                    `;
                }

                menu.innerHTML = html;
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
        Swal.fire({
            title: '¿Estás seguro?',
            text: "¡Esta acción no se puede deshacer!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sí, eliminar',
            position: 'top',
            cancelButtonText: 'Cancelar',
         
        }).then((result) => {
            if (result.isConfirmed) {
                let form = document.createElement('form');
                form.method = 'POST';
                form.action = '<?= Url::to(["reservas/delete", "id" => ""]) ?>' + id;

                let csrfToken = '<?= Yii::$app->request->getCsrfToken() ?>';
                let csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_csrf';
                csrfInput.value = csrfToken;
                form.appendChild(csrfInput);

                document.body.appendChild(form);
                form.submit();
            }
        });
    }
</script>
