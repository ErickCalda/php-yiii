<?php

use yii\helpers\Html;

$this->title = 'Nueva Materia';

?>

<div class="drawer-form">

    <?= $this->render('_form', [
        'model' => $model
    ]) ?>

</div>