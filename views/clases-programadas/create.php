<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\ClasesProgramadas $model */

$this->title = Yii::t('app', 'Create Clases Programadas');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Clases Programadas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="clases-programadas-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
