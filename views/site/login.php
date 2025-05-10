<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Iniciar Sesión';
?>
<h1><?= Html::encode($this->title) ?></h1>

<div class="site-login">
    <p>Por favor, llene los siguientes campos para iniciar sesión:</p>

    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
    ]); ?>

    <?= $form->field($model, 'correo')->textInput(['autofocus' => true]) ?>
    <?= $form->field($model, 'clave')->passwordInput() ?>
    <?= $form->field($model, 'rememberMe')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('Iniciar sesión', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
