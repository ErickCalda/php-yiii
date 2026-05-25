<?php

use app\models\Usuarios;
use yii\helpers\Html;
use yii\widgets\Pjax;

$this->title = 'Bitácora';
$this->params['breadcrumbs'][] = $this->title;

$isAdmin = !Yii::$app->user->isGuest &&
    Yii::$app->user->identity->rol_id == Usuarios::ROL_ADMIN;
?>

<div class="bitacora-page">

<!-- HEADER -->
<div class="page-head">

    <div>
        <h1>Bitácora</h1>
        <p>Actividad reciente y trazabilidad operativa del laboratorio.</p>
    </div>

    <div class="head-actions">

        <?php if ($isAdmin): ?>
            <button
                type="button"
                class="btn-primary"
                id="openCreateModal">
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

<?= Html::submitButton('Buscar', [
    'class' => 'btn-primary'
]) ?>

<?= Html::endForm() ?>

</div>

<?php Pjax::begin([
    'id' => 'bitacoraPjax'
]); ?>

<!-- TIMELINE -->
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

$usuario = $item->usuario
    ? $item->usuario->nombre . ' ' . $item->usuario->apellido
    : 'Usuario no disponible';

$laboratorio = $item->laboratorio
    ? $item->laboratorio->nombre
    : 'Sin laboratorio';

$tipo = $item->tipoEvento->nombre ?? 'Sin tipo';

$estado = $item->estado->nombre ?? 'Sin estado';

$fecha = $item->fecha_evento
    ? Yii::$app->formatter->asDatetime($item->fecha_evento)
    : 'Sin fecha';

$clase = $item->claseProgramada;

$detalleClase = '';

if ($clase) {

    $detalleClase =
        ucfirst($clase->dia_semana) . ' | ' .
        substr($clase->hora_inicio, 0, 5) . ' - ' .
        substr($clase->hora_fin, 0, 5);

    if ($clase->materia) {
        $detalleClase .= ' | ' . $clase->materia->nombre;
    }

    if ($clase->curso) {
        $detalleClase .= ' | ' . $clase->curso->nombre;
    }
}

?>

<article class="premium-card">

    <!-- TOP -->
    <div class="premium-top">

        <div class="premium-mark"></div>

        <div class="premium-main">

            <div class="premium-headline">

                <h3>
                    <?= Html::encode(
                        $item->titulo ?: 'Sin título'
                    ) ?>
                </h3>

                <time>
                    <i class="bi bi-calendar3"></i>
                    <?= $fecha ?>
                </time>

            </div>

            <p class="premium-desc">
                <?= nl2br(
                    Html::encode($item->descripcion)
                ) ?>
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

            <?php if ($detalleClase): ?>
                <span>
                    <i class="bi bi-journal-bookmark"></i>
                    <?= Html::encode($detalleClase) ?>
                </span>
            <?php endif; ?>

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
                    'data-confirm' =>
                        '¿Eliminar esta entrada?',
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

<?php Pjax::end(); ?>

</div>



<!-- =========================
     TABLE VIEW
========================= -->



<!-- MODAL -->
<div id="crudModal" class="crud-modal">

    <div class="crud-backdrop"></div>

    <div class="crud-box">

        <button class="close-modal" id="closeCrudModal">✕</button>

        <div id="crudContent"></div>

    </div>

</div>

</div>






<?php

$script = <<<JS

const modal = document.getElementById('crudModal');
const crudContent = document.getElementById('crudContent');

/* =========================================
   ABRIR MODAL
========================================= */

function openModal(url)
{
    fetch(url, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(res => res.text())
    .then(html => {

        crudContent.innerHTML = html;

        modal.classList.add('show');

    })
    .catch(error => {

        console.error(error);

    });
}

/* =========================================
   CREATE
========================================= */

document.getElementById('openCreateModal')
?.addEventListener('click', function (e) {

    e.preventDefault();

    const createUrl = "<?= \yii\helpers\Url::to(['bitacoras/create']) ?>";

    openModal(createUrl);

});

/* =========================================
   EDIT
========================================= */

document.addEventListener('click', function(e){

    const btn = e.target.closest('.open-edit');

    if(!btn) return;

    e.preventDefault();

    openModal(btn.href);

});

/* =========================================
   CERRAR MODAL
========================================= */

document.getElementById('closeCrudModal')
?.addEventListener('click', function(){

    modal.classList.remove('show');

});

document.querySelector('.crud-backdrop')
?.addEventListener('click', function(){

    modal.classList.remove('show');

});

/* =========================================
   FORM AJAX
========================================= */

document.addEventListener('submit', async function(e){

    const form = e.target.closest('#bitacora-form');

    if(!form) return;

    e.preventDefault();

    /* EVITAR DOBLE SUBMIT */

    if(form.dataset.sending === '1'){
        return;
    }

    form.dataset.sending = '1';

    try {

        const res = await fetch(form.action, {

            method: 'POST',
            body: new FormData(form),
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }

        });

        const contentType = res.headers.get('content-type');

        let response;

        if(contentType && contentType.includes('application/json')){

            response = await res.json();

        }else{

            response = await res.text();

        }

        /* SUCCESS */

        if(typeof response === 'object' && response.success){

            modal.classList.remove('show');

            $.pjax.reload({
                container:'#bitacoraPjax'
            });

            return;
        }

        /* VALIDACION */

        crudContent.innerHTML = response;

    } catch(error){

        console.error(error);

    } finally {

        form.dataset.sending = '0';

    }

});

JS;

$this->registerJs($script);

?>