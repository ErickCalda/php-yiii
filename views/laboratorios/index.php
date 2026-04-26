<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\models\LaboratoriosSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */


$this->title = 'Laboratorios';
$this->params['breadcrumbs'][] = $this->title;

$models = $dataProvider->getModels();
$total  = $dataProvider->getTotalCount();
?>

<div class="labs-premium">

<!-- HERO -->
<section class="hero-panel">

    <div class="hero-left">

        <span class="mini-badge">Sistema Inteligente</span>

        <h1><?= Html::encode($this->title) ?></h1>

        <p>
            Administra espacios académicos con una interfaz moderna,
            visual y totalmente responsive.
        </p>

    </div>

    <div class="hero-right">

        <?= Html::a(
            '＋ Nuevo Laboratorio',
            ['create'],
            ['class' => 'btn-main']
        ) ?>

    </div>

</section>

<?php Pjax::begin([
    'timeout' => 5000,
    'enablePushState' => false,
]); ?>

<!-- TOPBAR -->
<section class="top-tools">

<?= Html::beginForm(['index'], 'get', [
    'data-pjax' => 1,
    'class' => 'search-box'
]) ?>

<input
type="text"
name="LaboratoriosSearch[nombre]"
value="<?= Html::encode($searchModel->nombre) ?>"
placeholder="Buscar laboratorio..."
class="search-input"
>

<button type="submit" class="btn-search">
Buscar
</button>

<?= Html::endForm() ?>

<div class="stats-row">

    <div class="stat-card">
        <small>Total</small>
        <strong><?= $total ?></strong>
    </div>





</div>

</section>

<!-- GRID -->
<section class="labs-grid">

<?php foreach($models as $model): ?>

<?php
$estado = $model->estado->nombre ?? 'Sin estado';
$color  = strtolower($model->estado->color ?? 'gray');
$tipo   = $model->tipo->nombre ?? 'General';
$ubi    = $model->ubicacionTexto ?? '-';
$responsable = $model->responsable->nombre ?? null;
$responsableTexto = $responsable ? $responsable : 'Sin responsable';
?>

<article class="lab-card reveal">

    <div class="card-top">

        <span class="code">
            <?= Html::encode($model->codigo) ?>
        </span>

        <span class="badge badge-<?= $color ?>">
            <?= Html::encode($estado) ?>
        </span>

    </div>

    <div class="card-center">

        <h3><?= Html::encode($model->nombre) ?></h3>

        <p class="type">
            <?= Html::encode($tipo) ?>
        </p>

    </div>

    <div class="meta-wrap">

        <div class="meta-item">
            <span>👥</span>
            <div>
                <small>Capacidad</small>
                <strong><?= $model->capacidad ?> personas</strong>
            </div>
        </div>

        <div class="meta-item">
            <span>📍</span>
            <div>
                <small>Ubicación</small>
                <strong><?= Html::encode($ubi) ?></strong>
            </div>
        </div>

        <div class="meta-item">
            <span>👤</span>
            <div>
                <small>Responsable</small>
                <strong><?= Html::encode($responsableTexto) ?></strong>
            </div>
        </div>

    </div>

    <div class="card-actions">

        <?= Html::a(
            'Ver detalle',
            ['view', 'id' => $model->id],
            ['class' => 'btn-soft']
        ) ?>

        <?php if(
            !Yii::$app->user->isGuest &&
            Yii::$app->user->identity->rol_id == \app\models\Usuarios::ROL_ADMIN
        ): ?>



        <?php endif; ?>

    </div>

</article>

<?php endforeach; ?>

</section>

<?php Pjax::end(); ?>

</div>

<div id="floatingMenu" class="floating-menu"></div>

<script>
document.addEventListener('DOMContentLoaded', initPremium);
document.addEventListener('pjax:end', initPremium);

function initPremium(){
initMenus();
initReveal();
}

function initReveal(){

const items = document.querySelectorAll('.reveal');

const io = new IntersectionObserver(entries => {
entries.forEach(entry=>{
if(entry.isIntersecting){
entry.target.classList.add('show');
}
});
},{threshold:.12});

items.forEach(el=>io.observe(el));
}

function initMenus(){

const menu = document.getElementById('floatingMenu');
const buttons = document.querySelectorAll('.menu-btn');

buttons.forEach(btn=>{

btn.onclick = function(e){

e.stopPropagation();

const id = this.dataset.id;

menu.innerHTML = `
<a href="<?= Url::to(['view']) ?>?id=${id}">Ver</a>
<a href="<?= Url::to(['update']) ?>?id=${id}">Editar</a>
<button onclick="removeItem(${id})">Eliminar</button>
`;

const r = this.getBoundingClientRect();

let left = r.left - 130;
let top  = r.bottom + 10;

if(window.innerWidth < 768){
left = 16;
top = window.innerHeight - 220;
menu.style.width = (window.innerWidth - 32)+'px';
}else{
menu.style.width = '190px';
}

menu.style.left = left + 'px';
menu.style.top = top + 'px';

menu.classList.add('show');
}
});

document.onclick = closeMenu;
window.onscroll = closeMenu;
window.onresize = closeMenu;

function closeMenu(){
menu.classList.remove('show');
}
}
function removeItem(id){

    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '<?= Url::to(['delete']) ?>?id=' + id;

    const csrf = document.createElement('input');
    csrf.type = 'hidden';
    csrf.name = yii.getCsrfParam();
    csrf.value = yii.getCsrfToken();

    form.appendChild(csrf);
    document.body.appendChild(form);

    form.submit();
}
</script>
