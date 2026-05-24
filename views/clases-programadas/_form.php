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







$this->registerJs("

function cargarHoras(){

    let lab = $('#clasesprogramadas-laboratorio_id').val();
    let dia = $('#clasesprogramadas-dia_semana').val();
    let per = $('#clasesprogramadas-periodo_id').val();

    if(!lab || !dia || !per){
        return;
    }

    $.ajax({

        url: '" . Url::to(['get-horas-disponibles']) . "',
        type: 'POST',

        data: {
            laboratorio_id: lab,
            dia_semana: dia,
            periodo_id: per,
            _csrf: yii.getCsrfToken()
        },

        success: function(res){

            if(!res.ok){
                return;
            }

            let inicioOptions = '<option value=\"\">Hora inicio</option>';
            let finOptions    = '<option value=\"\">Hora fin</option>';

            res.horas.forEach(function(h){

                inicioOptions += '<option value=\"'+h+'\">'+h+'</option>';
                finOptions += '<option value=\"'+h+'\">'+h+'</option>';

            });

            $('#clasesprogramadas-hora_inicio').html(inicioOptions);
            $('#clasesprogramadas-hora_fin').html(finOptions);

            // volver a validar por si cambió disponibilidad
            checkHorario();
        }
    });
}

/* cuando cambie laboratorio/día/período */
$('#clasesprogramadas-laboratorio_id,\
#clasesprogramadas-dia_semana,\
#clasesprogramadas-periodo_id')
.on('change', cargarHoras);

", View::POS_READY);



/* ==========================================
   ALERTA02 PARA UPDATE
========================================== */
$this->registerJs("

$(document).on('beforeSubmit', 'form', function(e){

    e.preventDefault();

    let form = $(this);

    $.ajax({

        url: form.attr('action'),
        type: 'POST',
        data: form.serialize(),

        success:function(res){

            showToast(
                res.message,
                res.ok ? 'success' : 'error'
            );

            if(res.ok){

                setTimeout(function(){

                    window.location.href = '" . Url::to(['index']) . "';

                }, 900);

            }

        },

        error:function(){

            showToast(
                'Error de conexión con el servidor.',
                'error'
            );

        }

    });

    return false;

});

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

        \app\models\Laboratorios::find()

            ->where([
                'not in',
                'estado_id',
                \app\models\CatEstadosLaboratorio::find()
                    ->select('id')
                    ->where(['nombre' => [
                        'Mantenimiento',
                        'Reservado',
                        'Inactivo'
                    ]])
            ])

            ->orderBy('nombre')
            ->all(),

        'id',
        'nombre'
    ),

    ['prompt' => 'Seleccione laboratorio']

) ?>

<?php
$docentes = ArrayHelper::map(
    \app\models\Usuarios::find()
        ->where(['rol_id' => \app\models\Usuarios::ROL_DOCENTE])
        ->orderBy('nombre')
        ->all(),
    'id',
    function($u){
        return $u->nombre . ' ' . $u->apellido;
    }
);
?>

<?php

// si es nuevo registro
if ($model->isNewRecord) {

    // asignar automáticamente el usuario logueado
    $model->docente_id = Yii::$app->user->id;
}

$docenteActual = \app\models\Usuarios::findOne($model->docente_id);

?>

<?= $form->field($model, 'docente_id')
    ->hiddenInput()
    ->label(false) ?>

<div class="locked-user-box">
    Docente asignado:
    <strong>
        <?= Html::encode(
            $docenteActual
                ? $docenteActual->nombre . ' ' . $docenteActual->apellido
                : 'Sin docente'
        ) ?>
    </strong>
</div>

<!-- DÍA -->
<?= $form->field($model, 'dia_semana')->dropDownList([
    'lunes'     => 'Lunes',
    'martes'    => 'Martes',
    'miercoles' => 'Miércoles',
    'jueves'    => 'Jueves',
    'viernes'   => 'Viernes'
  
], ['prompt' => 'Seleccione día']) ?>






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

<?= $form->field($model, 'hora_inicio')->dropDownList(
    $model->hora_inicio
        ? [$model->hora_inicio => $model->hora_inicio]
        : [],
    ['prompt' => 'Seleccione hora inicio']
) ?>

<?= $form->field($model, 'hora_fin')->dropDownList(
    $model->hora_fin
        ? [$model->hora_fin => $model->hora_fin]
        : [],
    ['prompt' => 'Seleccione hora fin']
) ?>

<!-- ESTADO -->
<?php if($esAdmin): ?>

    <?= $form->field($model, 'estado')->dropDownList([
        0 => 'En progreso',
        1 => 'Activo',
        2 => 'Cancelado',
    ], [
        'prompt' => 'Seleccione estado'
    ]) ?>

<?php else: ?>

    <?php $model->estado = 0; ?>

    <?= $form->field($model, 'estado')
        ->hiddenInput()
        ->label(false) ?>

    <div class="locked-user-box">
        Estado inicial:
        <strong>En progreso</strong>
    </div>

<?php endif; ?>

<!-- MENSAJE -->
<div id="horario-msg" class="msg-box">
    Complete todos los campos para validar disponibilidad.
</div>

<!-- BOTÓN -->
<div class="actions-wrap">
<?= Html::submitButton(
    $model->isNewRecord ? 'Crear Reserva' : 'Actualizar Reserva',
    [
        'class' => 'btn-primary',
        'disabled' => $model->isNewRecord ? true : false
    ]
) ?>
</div>

<?php ActiveForm::end(); ?>

</div>


<style>

/* ==========================================
   EJECUTIVA01 — FORMULARIO CORPORATIVO
========================================== */

:root{

    --bg:#F3F6F9;
    --surface:#FFFFFF;

    --navy:#1F2937;
    --navy-dark:#111827;

    --line:#C7D0DA;
    --line-dark:#94A3B8;

    --text:#111827;
    --muted:#6B7280;

    --primary:#374151;
    --primary-hover:#111827;

    --success:#166534;
    --danger:#991B1B;

}


/* CONTENEDOR */
.form-card{

    max-width:100%;
    margin:auto;

    background:var(--surface);

    border:1px solid var(--line-dark);
    border-radius:5px;

    padding:26px;

    box-shadow:
        inset 0 1px 0 rgba(255,255,255,.8),
        0 2px 6px rgba(0,0,0,.04);

}


/* GRID */
.grid-form{

    display:grid;

    grid-template-columns:repeat(2,minmax(280px,1fr));

    gap:18px;

    align-items:start;

}


/* LABELS */
label{

    display:block;

    margin-bottom:7px;

    font-family:"Segoe UI", system-ui;

    font-size:12px;
    font-weight:700;

    letter-spacing:.4px;
    text-transform:uppercase;

    color:#475569;

}


/* INPUTS */
.form-control{

    width:100%;

    height:42px;

    background:#FFFFFF;

    border:1px solid var(--line);
    border-radius:4px !important;

    font-size:13px;
    font-weight:600;

    color:var(--text);

    padding:0 12px;

    box-shadow:none !important;

    transition:.15s ease;

}


/* FOCUS */
.form-control:focus{

    border-color:#64748B !important;

    outline:none;

    box-shadow:
        inset 0 0 0 1px #64748B !important;

}


/* SELECT */
select.form-control{

    cursor:pointer;

}


/* BLOQUE BLOQUEADO */
.locked-user-box{

    min-height:42px;

    display:flex;
    align-items:center;

    padding:0 14px;

    background:#F8FAFC;

    border:1px solid var(--line);
    border-radius:4px;

    font-size:13px;
    font-weight:600;

    color:#334155;

}


/* MENSAJE DE VALIDACIÓN */
.msg-box{

    grid-column:1 / -1;

    margin-top:6px;

    padding:12px 14px;

    background:#F8FAFC;

    border:1px solid #E2E8F0;
    border-radius:4px;

    font-size:12px;
    font-weight:600;

    color:#64748B;

}


/* ===============================
   EXECUTIVA01 — ACTIONS
================================= */

.actions-wrap{
    grid-column: 1 / -1;

    display:flex;
    justify-content:flex-end;
    align-items:center;

    margin-top:10px;
    padding-top:20px;

    border-top:1px solid #D6DCE5;
}

/* BOTÓN CORPORATIVO */
.btn-primary{
    min-width:220px;
    height:44px;

    display:inline-flex;
    align-items:center;
    justify-content:center;

    padding:0 24px;

    background:linear-gradient(
        to bottom,
        #445067 0%,
        #374151 100%
    );

    color:#FFFFFF;
    font-family:"Segoe UI", sans-serif;
    font-size:14px;
    font-weight:600;
    letter-spacing:.2px;

    border:1px solid #2A3444;
    border-radius:5px;

    cursor:pointer;

    box-shadow:
        inset 0 1px 0 rgba(255,255,255,.08),
        0 2px 8px rgba(15,23,42,.10);

    transition:.16s ease;
}

/* HOVER */
.btn-primary:hover{
    background:linear-gradient(
        to bottom,
        #4B586F 0%,
        #3B4658 100%
    );

    border-color:#1F2937;
}

/* CLICK */
.btn-primary:active{
    transform:translateY(1px);

    box-shadow:
        inset 0 2px 4px rgba(0,0,0,.12);
}

/* DESACTIVADO */
.btn-primary:disabled{
    background:#AEB8C7;
    border-color:#9AA5B5;
    color:#F8FAFC;
    cursor:not-allowed;
    box-shadow:none;
    transform:none;
}

/* RESPONSIVE */
@media(max-width:768px){

    .actions-wrap{
        justify-content:stretch;
    }

    .btn-primary{
        width:100%;
        min-width:unset;
    }

}


/* CAMPOS CON ERROR */
.has-error .form-control{

    border-color:#991B1B !important;

}


/* HELP BLOCK */
.help-block{

    margin-top:5px;

    font-size:11px;
    font-weight:600;

    color:#991B1B;

}


/* TABLET */
@media(max-width:980px){

    .grid-form{

        grid-template-columns:1fr;

    }

    .actions-wrap{

        justify-content:flex-start;

    }

}


/* MOBILE */
@media(max-width:600px){

    .form-card{

        padding:16px;

    }

    .btn-primary{

        width:100%;

    }

}

</style>