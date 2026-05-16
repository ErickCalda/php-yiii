<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Iniciar Sesión';
?>

<div class="executive-login-wrapper">

    <div class="executive-login-card">



        <div class="executive-header">
            <h1><?= Html::encode($this->title) ?></h1>
            <p>Acceso al sistema</p>
        </div>

        <?php $form = ActiveForm::begin([
            'id' => 'login-form',
            'options' => ['class' => 'executive-form']
        ]); ?>

        <div class="executive-field">
            <?= $form->field($model, 'correo')
                ->textInput([
                    'autofocus' => true,
                    'placeholder' => 'correo@institucion.com'
                ])
                ->label('Correo institucional') ?>
        </div>

        <div class="executive-field">
            <?= $form->field($model, 'clave')
                ->passwordInput([
                    'placeholder' => '••••••••'
                ])
                ->label('Contraseña') ?>
        </div>
                <!-- LOADER -->
        <span class="loader" id="loginLoader" style="display:none;"></span>

        <div class="executive-check">
            <?= $form->field($model, 'rememberMe')->checkbox() ?>
        </div>

        <div class="executive-actions">
            <?= Html::submitButton('Iniciar sesión', [
                'class' => 'executive-btn primary',
                'name' => 'login-button'
            ]) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>



<?php
$this->registerJs("
$('#login-form').on('beforeSubmit', function (e) {

    let btn = $('.executive-btn.primary');

    // evitar doble click
    if (btn.data('loading')) {
        return false;
    }

    btn.data('loading', true);

    // cambiar estado del botón
    btn.text('Validando...');
    btn.prop('disabled', true);

    // mostrar spinner
    $('#loginLoader').show();

    // simular delay UX (puedes ajustar 1200 - 2000ms)
    setTimeout(() => {
        this.submit();
    }, 1500);

    return false; // detiene envío inmediato
});
");
?>



<style>


/* =========================
   WRAPPER
========================= */
.executive-login-wrapper {
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    background: #f5f7fb;
    font-family: "Segoe UI", Inter, sans-serif;
    padding: 20px;
}

/* =========================
   CARD
========================= */
.executive-login-card {
    width: 420px;
    background: #1e2a44;
    border: 1px solid #2c3b5e;
    border-radius: 5px;
    padding: 28px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    position: relative;
    animation: fadeUp 0.3s ease-out;
}

@keyframes fadeUp {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(-10px); }
}

/* =========================
   HEADER
========================= */
.executive-header {
    text-align: center;
    margin-bottom: 20px;
}

.executive-header h1 {
    font-size: 20px;
    color: #ffffff;
    margin-bottom: 6px;
    font-weight: 600;
}

.executive-header p {
    font-size: 13px;
    color: #b6c2d9;
    margin: 0;
}

/* =========================
   INPUTS
========================= */
.executive-field label {
    color: #d7e1f5;
    font-size: 13px;
}

.executive-field input {
    width: 100%;
    padding: 10px 12px;
    background: #0f1a2e;
    border: 1px solid #324766;
    border-radius: 4px;
    color: #ffffff;
    outline: none;
    transition: 0.2s ease;
}

.executive-field input:focus {
    border-color: #5b7bbf;
    box-shadow: 0 0 0 3px rgba(91, 123, 191, 0.25);
}

/* =========================
   CHECKBOX
========================= */
.executive-check {
    margin-top: 10px;
    color: #cbd5e1;
    font-size: 13px;
}

/* =========================
   BOTÓN
========================= */
.executive-btn.primary {
    width: 100%;
    padding: 10px;
    background: #3b82f6;
    border: 1px solid #3b82f6;
    color: #ffffff;
    border-radius: 4px;
    cursor: pointer;
    font-weight: 600;
    transition: 0.2s ease;
}

.executive-btn.primary:hover {
    background: #2563eb;
}

/* =========================
   LOADER
========================= */
.loader {
    width: 30px;
    height: 30px;
    margin: 10px auto 20px auto;
    position: relative;
    display: block;
}

.loader:before {
    content: '';
    width: 42px;
    height: 5px;
    background: rgba(0,0,0,0.4);
    position: absolute;
    top: 55px;
    left: 0;
    border-radius: 50%;
    animation: shadow 0.5s linear infinite;
}

.loader:after {
    content: '';
    width: 100%;
    height: 100%;
    background: #3b82f6;
    animation: bxSpin 0.5s linear infinite;
    position: absolute;
    top: 0;
    left: 0;
    border-radius: 4px;
}

/* animación caja */
@keyframes bxSpin {
    17% { border-bottom-right-radius: 3px; }
    25% { transform: translateY(9px) rotate(22.5deg); }
    50% { transform: translateY(18px) scale(1, .9) rotate(45deg); border-bottom-right-radius: 40px; }
    75% { transform: translateY(9px) rotate(67.5deg); }
    100% { transform: translateY(0) rotate(90deg); }
}

@keyframes shadow {
    0%, 100% { transform: scale(1, 1); }
    50% { transform: scale(1.2, 1); }
}

/* =========================
   RESPONSIVE
========================= */
@media (max-width: 480px) {
    .executive-login-card {
        width: 100%;
    }
}



</style>




