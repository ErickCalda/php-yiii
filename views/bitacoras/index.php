
<?php

use app\models\Bitacoras;
use app\models\Usuarios;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\grid\ActionColumn;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var app\models\BitacorasSearch $searchModel */

$this->title = 'Bitácora';
$this->params['breadcrumbs'][] = $this->title;

$isAdmin = !Yii::$app->user->isGuest
    && Yii::$app->user->identity->rol_id == Usuarios::ROL_ADMIN;
?>

<div class="bitacora-page">

    <!-- HEADER -->
    <div class="page-head">

        <div>
            <h1>Bitácora</h1>
            <p>Actividad reciente y trazabilidad operativa del sistema.</p>
        </div>

        <div class="head-actions">

            <button type="button" class="view-btn active" id="btnTimeline">
                Timeline
            </button>

            <button type="button" class="view-btn" id="btnTable">
                Tabla
            </button>

            <?php if ($isAdmin): ?>
               <button type="button" class="btn-primary" id="openCreateModal">
                + Nueva entrada
            </button>
            <?php endif; ?>

        </div>

    </div>

    <!-- SEARCH -->
    <div class="toolbar">

        <?= Html::beginForm(['bitacoras/index'], 'get') ?>

        <?= Html::input(
            'text',
            'BitacorasSearch[descripcion]',
            Yii::$app->request->get('BitacorasSearch')['descripcion'] ?? '',
            [
                'class' => 'search-input',
                'placeholder' => 'Buscar descripción...'
            ]
        ) ?>

        <?= Html::submitButton('Buscar', ['class' => 'btn-primary']) ?>

        <?= Html::endForm() ?>

    </div>

   <?php Pjax::begin(['id' => 'bitacoraPjax']); ?>


<!-- TIMELINE VIEW -->
<div id="timelineView">

    <div class="timeline">

        <?php if (empty($dataProvider->models)): ?>

            <div class="empty-state">
                <h3>Sin registros</h3>
                <p>No hay entradas disponibles.</p>
            </div>

        <?php else: ?>

            <?php foreach ($dataProvider->models as $item): ?>

                <?php
                $usuario = $item->reserva && $item->reserva->usuario
                    ? $item->reserva->usuario->nombre . ' ' . $item->reserva->usuario->apellido
                    : 'Usuario no disponible';

                $laboratorio = $item->reserva && $item->reserva->laboratorio
                    ? $item->reserva->laboratorio->nombre
                    : 'Laboratorio';

                $fecha = Yii::$app->formatter->asDatetime($item->fecha_registro);
                ?>

                <div class="log-item">

                    <div class="dot"></div>

                    <div class="log-card">

                        <div class="log-top">

                            <div>
                                <h3><?= Html::encode($laboratorio) ?></h3>
                                <span><?= Html::encode($usuario) ?></span>
                            </div>

                            <small><?= $fecha ?></small>

                        </div>

                        <div class="log-body">
                            <?= nl2br(Html::encode($item->descripcion)) ?>
                        </div>

                        <?php if ($isAdmin): ?>

                            <div class="log-actions">

                                <?= Html::a(
                                    '<i class="bi bi-pencil"></i>',
                                    ['update', 'id' => $item->id],
                                    [
                                        'class' => 'action-icon open-edit',
                                        'title' => 'Editar'
                                    ]
                                ) ?>

                                <?= Html::a(
                                    '<i class="bi bi-trash"></i>',
                                    ['delete', 'id' => $item->id],
                                    [
                                        'class' => 'action-icon danger',
                                        'title' => 'Eliminar',
                                        'data-confirm' => '¿Eliminar esta entrada?',
                                        'data-method' => 'post',
                                    ]
                                ) ?>

                            </div>

                        <?php endif; ?>

                    </div>

                </div>

            <?php endforeach; ?>

        <?php endif; ?>

    </div>

</div>



    </div><!-- TABLE VIEW -->
<div id="tableView" style="display:none;">

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => null,

    'columns' => [

        ['class' => 'yii\grid\SerialColumn'],

        [
            'label' => 'Usuario',
            'value' => function ($model) {
                return $model->reserva && $model->reserva->usuario
                    ? $model->reserva->usuario->nombre
                    : 'No disponible';
            }
        ],

        [
            'label' => 'Laboratorio',
            'value' => function ($model) {
                return $model->reserva && $model->reserva->laboratorio
                    ? $model->reserva->laboratorio->nombre
                    : 'No disponible';
            }
        ],

        [
            'attribute' => 'descripcion',
            'format' => 'ntext'
        ],

        [
            'attribute' => 'fecha_registro',
            'format' => 'datetime'
        ],

      [
    'class' => ActionColumn::class,
    'template' => '{update} {delete}',

    'buttons' => [

        'update' => function ($url, $model) {
            return Html::a(
                '<i class="bi bi-pencil"></i>',
                $url,
                [
                    'class' => 'action-icon open-edit',
                    'title' => 'Editar'
                ]
            );
        },

        'delete' => function ($url, $model) {
            return Html::a(
                '<i class="bi bi-trash"></i>',
                $url,
                [
                    'class' => 'action-icon danger',
                    'title' => 'Eliminar',
                    'data-confirm' => '¿Eliminar esta entrada?',
                    'data-method' => 'post',
                ]
            );
        },

    ],

    'urlCreator' => function ($action, Bitacoras $model) {
        return Url::to([$action, 'id' => $model->id]);
    }
]
    ]
]); ?>

</div>
    <?php Pjax::end(); ?>

    <!-- MODAL -->
<div id="crudModal" class="crud-modal">

    <div class="crud-backdrop"></div>

    <div class="crud-box">

        <button class="close-modal" id="closeCrudModal">✕</button>

        <div id="crudContent"></div>

    </div>

</div>

</div>
<!-- REEMPLAZA TU <style> Y <script> POR ESTE BLOQUE MEJORADO -->

