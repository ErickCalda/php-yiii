<?php

/** @var yii\web\View $this */
/** @var app\models\Bitacoras $model */

$this->title = 'Editar entrada';
?>

<div class="modal-head">
    <h2>Editar entrada</h2>
    <p>Actualiza la información registrada en la bitácora.</p>
</div>

<?= $this->render('_form', [
    'model' => $model,
]) ?>