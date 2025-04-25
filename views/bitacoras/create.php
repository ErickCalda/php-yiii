<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Bitacoras $model */

$this->title = Yii::t('app', 'Create Bitacoras');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Bitacoras'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bitacoras-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
