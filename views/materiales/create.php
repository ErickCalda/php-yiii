<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Materiales $model */

$this->title = Yii::t('app', 'Create Materiales');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Materiales'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="materiales-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
