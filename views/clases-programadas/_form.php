<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\View;

/* ==========================================
   VALIDACIÓN AJAX HORARIO
========================================== */
$this->registerJs("

function checkHorario(){

    let lab      = $('#clasesprogramadas-laboratorio_id').val();
    let docente  = $('#clasesprogramadas-docente_id').val();
    let curso    = $('#clasesprogramadas-curso_id').val();
    let periodo  = $('#clasesprogramadas-periodo_id').val();
    let dia      = $('#clasesprogramadas-dia_semana').val();
    let ini      = $('#clasesprogramadas-hora_inicio').val();
    let fin      = $('#clasesprogramadas-hora_fin').val();

    if(!lab || !docente || !curso || !periodo || !dia || !ini || !fin){

        $('#horario-msg').text('Complete todos los campos para validar disponibilidad.');
        $('#horario-msg').css('color','#64748B');

        $('button[type=submit]').prop('disabled', true);
        return;
    }

    $('#horario-msg').text('Validando horario...');
    $('#horario-msg').css('color','#6366F1');

    $.ajax({
        url: '" . Url::to(['check-horario']) . "',
        type:'POST',

        data:{
            laboratorio_id: lab,
            docente_id: docente,
            curso_id: curso,
            periodo_id: periodo,
            dia_semana: dia,
            hora_inicio: ini,
            hora_fin: fin,
            _csrf: yii.getCsrfToken()
        },

        success:function(res){

            $('#horario-msg').text(res.msg);

            if(res.ok){
                $('#horario-msg').css('color','#16A34A');
                $('button[type=submit]').prop('disabled', false);
            }else{
                $('#horario-msg').css('color','#DC2626');
                $('button[type=submit]').prop('disabled', true);
            }
        },

        error:function(){
            $('#horario-msg').text('No se pudo validar.');
            $('#horario-msg').css('color','#DC2626');
            $('button[type=submit]').prop('disabled', true);
        }
    });
}

$('#clasesprogramadas-laboratorio_id,\
#clasesprogramadas-docente_id,\
#clasesprogramadas-curso_id,\
#clasesprogramadas-periodo_id,\
#clasesprogramadas-dia_semana,\
#clasesprogramadas-hora_inicio,\
#clasesprogramadas-hora_fin')
.on('change keyup', checkHorario);

", View::POS_READY);

$usuario = Yii::$app->user->identity;
$esAdmin = $usuario->rol_id == \app\models\Usuarios::ROL_ADMIN;

?>

<div class="form-card">

<?php $form = ActiveForm::begin(); ?>

<div class="grid-form">

<!-- LABORATORIO -->
<?= $form->field($model, 'laboratorio_id')->dropDownList(
    ArrayHelper::map(
        \app\models\Laboratorios::find()->orderBy('nombre')->all(),
        'id',
        'nombre'
    ),
    ['prompt' => 'Seleccione laboratorio']
) ?>

<!-- DOCENTE SEGÚN ROL -->
<?php if($esAdmin): ?>

<?= $form->field($model, 'docente_id')->dropDownList(
    ArrayHelper::map(
        \app\models\Usuarios::find()
            ->where(['rol_id' => \app\models\Usuarios::ROL_DOCENTE])
            ->orderBy('nombre')
            ->all(),
        'id',
        function($u){
            return $u->nombre . ' ' . $u->apellido;
        }
    ),
    ['prompt' => 'Seleccione docente']
) ?>

<?php else: ?>

<?php $model->docente_id = $usuario->id; ?>

<?= $form->field($model, 'docente_id')
    ->hiddenInput()
    ->label(false) ?>

<div class="locked-user-box">
    Docente asignado:
    <strong>
        <?= Html::encode($usuario->nombre . ' ' . $usuario->apellido) ?>
    </strong>
</div>

<?php endif; ?>

<!-- DÍA -->
<?= $form->field($model, 'dia_semana')->dropDownList([
    'lunes'     => 'Lunes',
    'martes'    => 'Martes',
    'miercoles' => 'Miércoles',
    'jueves'    => 'Jueves',
    'viernes'   => 'Viernes',
    'sabado'    => 'Sábado',
], ['prompt' => 'Seleccione día']) ?>

<!-- HORAS -->
<?= $form->field($model, 'hora_inicio')->input('time') ?>

<?= $form->field($model, 'hora_fin')->input('time') ?>

<!-- MATERIA -->
<?= $form->field($model, 'materia_id')->dropDownList(
    ArrayHelper::map(
        \app\models\Materias::find()->orderBy('nombre')->all(),
        'id',
        'nombre'
    ),
    ['prompt' => 'Seleccione materia']
) ?>

<!-- CURSO -->
<?= $form->field($model, 'curso_id')->dropDownList(
    ArrayHelper::map(
        \app\models\Cursos::find()->orderBy('nombre')->all(),
        'id',
        'nombre'
    ),
    ['prompt' => 'Seleccione curso']
) ?>

<!-- PERIODO -->
<?= $form->field($model, 'periodo_id')->dropDownList(
    ArrayHelper::map(
        \app\models\PeriodosAcademicos::find()
            ->where(['activo' => 1])
            ->orderBy('nombre')
            ->all(),
        'id',
        'nombre'
    ),
    ['prompt' => 'Seleccione período']
) ?>

<!-- ESTADO -->
<?= $form->field($model, 'estado')->dropDownList([
    1 => 'Activo',
    0 => 'Inactivo',
], ['prompt' => 'Seleccione estado']) ?>

</div>

<!-- MENSAJE -->
<div id="horario-msg" class="msg-box">
    Complete todos los campos para validar disponibilidad.
</div>

<!-- BOTÓN -->
<div class="actions-wrap">
<?= Html::submitButton('Guardar Reserva', [
    'class' => 'btn-primary',
    'disabled' => true
]) ?>
</div>

<?php ActiveForm::end(); ?>

</div>





<style>

:root{
    --bg:#FFFFFF;
    --line:#E2E8F0;
    --text:#0F172A;
    --muted:#64748B;
    --indigo:#4F46E5;
    --success:#16A34A;
    --danger:#DC2626;
}

/* CARD */
.form-card{
    background:#fff;
    border:1px solid var(--line);
    border-radius:22px;
    padding:24px;
    box-shadow:0 18px 40px rgba(15,23,42,.06);
}

/* GRID */
.grid-form{
    display:grid;
    grid-template-columns:repeat(2,1fr);
    gap:18px;
}

/* INPUTS */
.form-control{
    border-radius:14px !important;
    border:1px solid var(--line) !important;
    min-height:46px;
    box-shadow:none !important;
}

.form-control:focus{
    border-color:var(--indigo) !important;
    box-shadow:0 0 0 4px rgba(79,70,229,.08) !important;
}

/* LABEL */
label{
    font-size:13px;
    font-weight:700;
    color:var(--text);
}

/* MSG */
.msg-box{
    margin-top:18px;
    padding:12px 14px;
    border-radius:14px;
    background:#F8FAFC;
    color:var(--muted);
    font-weight:600;
    font-size:13px;
}

/* BUTTON */
.actions-wrap{
    margin-top:20px;
}

.btn-primary{
    background:linear-gradient(135deg,#6366F1,#4F46E5);
    color:#fff;
    padding:12px 20px;
    border:none;
    border-radius:14px;
    font-weight:700;
    cursor:pointer;
    transition:.2s ease;
}

.btn-primary:hover{
    transform:translateY(-2px);
}

.btn-primary:disabled{
    opacity:.5;
    cursor:not-allowed;
    transform:none;
}

/* MOBILE */
@media(max-width:800px){
    .grid-form{
        grid-template-columns:1fr;
    }
}



.locked-user-box{
    padding:14px 16px;
    border-radius:16px;
    background:#EEF2FF;
    border:1px solid #C7D2FE;
    color:#4F46E5;
    font-size:14px;
    font-weight:700;
    margin-bottom:18px;
}


</style>