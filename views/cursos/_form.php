<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;

?>

<style>
/* Contenedor minimal SaaS */
.form-saas {
    max-width: 480px;
    margin: 60px auto;
    padding: 24px;
    font-family: system-ui, -apple-system, Segoe UI, Roboto, sans-serif;
}

/* Label */
.form-saas label {
    font-size: 13px;
    font-weight: 500;
    color: #374151;
    margin-bottom: 6px;
    display: block;
}

/* Input limpio */
.form-saas input {
    width: 100%;
    padding: 10px 12px;
    font-size: 14px;
    border: 1px solid #e5e7eb;
    border-radius: 10px;
    background: #ffffff;
    outline: none;
    transition: 0.15s ease;
    color: #111827;
}

.form-saas input::placeholder {
    color: #9ca3af;
}

.form-saas input:focus {
    border-color: #6366f1;
    box-shadow: 0 0 0 3px rgba(99,102,241,0.18);
}

/* Botón estilo SaaS (acento consistente) */
.btn-soft {
    width: 100%;
    padding: 10px 12px;
    border-radius: 10px;
    border: 1px solid transparent;
    background: #6366f1; /* acento */
    color: #ffffff;
    font-size: 14px;
    font-weight: 500;
    cursor: pointer;
    transition: 0.15s ease;
}

.btn-soft:hover {
    background: #4f46e5;
}

.btn-soft:active {
    transform: scale(0.98);
}
</style>

<div class="form-saas">

<?php $form = ActiveForm::begin([
    'id' => 'curso-form'
]); ?>

<?= $form->field($model, 'nombre')
    ->textInput([
        'placeholder' => 'Nombre del curso'
    ]) ?>

<?= Html::submitButton('Guardar', [
    'class' => 'btn-soft'
]) ?>

<?php ActiveForm::end(); ?>

</div>