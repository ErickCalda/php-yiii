<?php

/** @var yii\web\View $this */
/** @var app\models\Bitacoras $model */

$this->title = 'Nueva entrada';
?>

<div class="modal-head">
    <h2>Nueva entrada</h2>
    <p>Registra una nueva actividad en la bitácora.</p>
</div>

<?= $this->render('_form', [
    'model' => $model
]) ?>

<style>
.modal-head{
    margin-bottom:22px;
}

.modal-head h2{
    margin:0;
    font-size:28px;
    font-weight:800;
    color:#0F172A;
    letter-spacing:-0.5px;
}

.modal-head p{
    margin:8px 0 0;
    color:#64748B;
    font-size:14px;
}
</style>