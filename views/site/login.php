<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Iniciar Sesión';
?>
<div class="flex items-center justify-center min-h-screen bg-gradient-to-r from-gray-900 via-indigo-900 to-gray-900">
    <div class="bg-white p-8 rounded-2xl shadow-xl w-full max-w-md transform transition duration-500 hover:scale-105">
        <h2 class="text-3xl font-bold text-center text-indigo-600 mb-6">Bienvenido</h2>

        <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

        <div class="mb-4">
            <?= $form->field($model, 'correo')->textInput([ // Cambiado de 'email' a 'correo'
                'class' => 'w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500',
                'placeholder' => 'Correo Electrónico'
            ])->label(false) ?>
        </div>

        <div class="mb-4">
            <?= $form->field($model, 'password')->passwordInput([
                'class' => 'w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500',
                'placeholder' => 'Contraseña'
            ])->label(false) ?>
        </div>

        <div class="flex items-center justify-between mb-4">
            <label class="inline-flex items-center">
                <?= $form->field($model, 'rememberMe')->checkbox(['class' => 'form-checkbox text-indigo-600'])->label('Recordarme') ?>
            </label>
        </div>

        <div>
            <?= Html::submitButton('Entrar', ['class' => 'w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
