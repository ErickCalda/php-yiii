<?php

use app\models\Bitacoras;
use app\models\Usuarios;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\grid\ActionColumn;
use yii\widgets\Pjax;

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

<!-- =========================
     TIMELINE VIEW
========================= -->




<div id="timelineView">

    <div class="timeline-premium">

        <?php if (empty($dataProvider->models)): ?>

            <div class="empty-state">
                <h3>Sin registros</h3>
                <p>No hay actividad disponible.</p>
            </div>

        <?php else: ?>

            <?php foreach ($dataProvider->models as $item): ?>

                <?php
                $usuario = $item->reserva && $item->reserva->usuario
                    ? $item->reserva->usuario->nombre . ' ' . $item->reserva->usuario->apellido
                    : 'Usuario no disponible';

                $laboratorio = $item->reserva && $item->reserva->laboratorio
                    ? $item->reserva->laboratorio->nombre
                    : 'Sin laboratorio';

                $tipo = $item->tipoEvento?->nombre ?? 'Sin tipo';
                $estado = $item->estado?->nombre ?? 'Sin estado';

                $fecha = $item->fecha_evento
                    ? Yii::$app->formatter->asDatetime($item->fecha_evento)
                    : 'Sin fecha';
                ?>

                <article class="premium-card">

                    <!-- TOP -->
                    <div class="premium-top">

                        <div class="premium-mark"></div>

                        <div class="premium-main">

                            <div class="premium-headline">

                                <h3>
                                    <?= Html::encode($item->titulo ?: 'Sin título') ?>
                                </h3>

                                <time>
                                    <i class="bi bi-calendar3"></i>
                                    <?= $fecha ?>
                                </time>

                            </div>

                            <p class="premium-desc">
                                <?= nl2br(Html::encode($item->descripcion)) ?>
                            </p>

                        </div>

                    </div>

                    <!-- FOOT -->
                    <div class="premium-foot">

                        <div class="premium-tags">

                            <span>
                                <i class="bi bi-person-circle"></i>
                                <?= Html::encode($usuario) ?>
                            </span>

                            <span>
                                <i class="bi bi-building"></i>
                                <?= Html::encode($laboratorio) ?>
                            </span>

                            <span>
                                <i class="bi bi-tag"></i>
                                <?= Html::encode($tipo) ?>
                            </span>

                            <span>
                                <i class="bi bi-shield-check"></i>
                                <?= Html::encode($estado) ?>
                            </span>

                        </div>

                        <?php if ($isAdmin): ?>

                            <div class="premium-actions">

                                <?= Html::a(
                                    '<i class="bi bi-pencil"></i>',
                                    ['update', 'id' => $item->id],
                                    [
                                        'class' => 'premium-btn open-edit',
                                        'title' => 'Editar'
                                    ]
                                ) ?>

                                <?= Html::a(
                                    '<i class="bi bi-trash"></i>',
                                    ['delete', 'id' => $item->id],
                                    [
                                        'class' => 'premium-btn danger',
                                        'title' => 'Eliminar',
                                        'data-confirm' => '¿Eliminar esta entrada?',
                                        'data-method' => 'post',
                                    ]
                                ) ?>

                            </div>

                        <?php endif; ?>

                    </div>

                </article>

            <?php endforeach; ?>

        <?php endif; ?>

    </div>

</div>






<!-- =========================
     TABLE VIEW
========================= -->


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