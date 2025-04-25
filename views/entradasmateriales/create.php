<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\EntradasMateriales $model */

$this->title = Yii::t('app', 'Create Entradas Materiales');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Entradas Materiales'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="entradas-materiales-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
