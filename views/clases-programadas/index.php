<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\helpers\Url;

$this->title = 'Horario de Clases';
$this->params['breadcrumbs'][] = $this->title;

$models = $dataProvider->getModels();

/* AGRUPAR POR DÍA */
$horario = [];

foreach ($models as $m) {
    $dia = trim(strtolower($m->dia_semana ?? ''));
    $horario[$dia][] = $m;
}

/* SOLO UNA VEZ CADA DÍA */
$dias = [
    'lunes',
    'martes',
    'miercoles',
    'jueves',
    'viernes',
  
];
?>

<<div class="schedule-page">

    <!-- HERO -->
    <div class="hero-panel">

        <div>
            <span class="mini-badge">Vista Horario</span>
            <h1><?= Html::encode($this->title) ?></h1>
            <p>Distribución semanal de clases programadas en tiempo real</p>
        </div>

<?= Html::a('🖨️ Imprimir Horario', [
    'imprimir-horario'
], [
    'class' => 'btn-soft',
    'target' => '_blank',
    'data-pjax' => 0
]) ?>

        <div class="cp-actions">

            <button type="button"
                    class="drawer-trigger btn-soft"
                    data-title="Nuevo Curso"
                    data-url="<?= Url::to(['/cursos/create']) ?>">
                + Curso
            </button>

            <button type="button"
                    class="drawer-trigger btn-soft"
                    data-title="Nueva Materia"
                    data-url="<?= Url::to(['/materias/create']) ?>">
                + Materia
            </button>

            <button type="button"
                    class="drawer-trigger btn-soft"
                    data-title="Nuevo Período"
                    data-url="<?= Url::to(['/periodos-academicos/create']) ?>">
                + Período
            </button>

        </div>

    </div>

    <?php Pjax::begin(); ?>

    <div class="schedule-grid">

        <?php foreach ($dias as $dia): ?>

            <div class="day-column">

                <div class="day-header">
                    <?= ucfirst($dia) ?>
                </div>

                <?php if (!empty($horario[$dia])): ?>

                    <?php foreach ($horario[$dia] as $m): ?>

                        <div class="class-block">

                            <!-- TOP -->
                            <div class="class-top">

                                <div class="class-name">
                                    <?= $m->usuarios->nombre ?? 'Docente' ?>
                                    <?= $m->usuarios->apellido ?? '' ?>
                                </div>

                                    <div class="class-status 
                                        <?= $m->estado == 0 ? 'progress' : ($m->estado == 1 ? 'on' : 'cancel') ?>">
                                        
                                        <?= $m->estado == 0 
                                            ? 'En progreso' 
                                            : ($m->estado == 1 ? 'Activo' : 'Cancelado') ?>
                                            
                                    </div>

                            </div>

                            <!-- BODY -->
                            <div class="class-time">
                                <?= $m->hora_inicio ?> — <?= $m->hora_fin ?>
                            </div>

                            <div class="class-title">
                                <?= $m->materias->nombre ?? 'Sin materia' ?>
                            </div>

                            <div class="class-sub">
                                <?= $m->cursos->nombre ?? 'Curso' ?>
                            </div>

                            <div class="class-meta">
                                🧪 <?= $m->laboratorios->nombre ?? 'Laboratorio' ?>
                            </div>

                            <!-- ACTIONS -->
                            <div class="class-actions">

                                <?php if ($m->puedeEditar()): ?>

                                    <?= Html::a('Ver', ['view', 'id' => $m->id]) ?>

                                    <?= Html::a('Editar', ['update', 'id' => $m->id]) ?>

<?php if (Yii::$app->user->identity->rol_id == app\models\Usuarios::ROL_ADMIN): ?>

    <?= Html::a(
        'Eliminar',
        ['delete', 'id' => $m->id],
        [
            'class' => 'delete-class',
            'data-pjax' => '0'
        ]
    ) ?>

<?php endif; ?>

                                <?php endif; ?>

                            </div>

                        </div>

                    <?php endforeach; ?>

                <?php else: ?>

                    <div class="empty-slot">
                        Sin clases
                    </div>

                <?php endif; ?>

            </div>

        <?php endforeach; ?>

    </div>

    <?php Pjax::end(); ?>

</div>

<?= Html::a('＋ Nueva Clase Programada', ['create'], [
    'class' => 'cp-fab'
]) ?>


<div class="drawer-overlay"></div>

<div class="drawer-panel">

    <div class="drawer-header">
        <h3 id="drawer-title">Nuevo Registro</h3>

        <button type="button" class="drawer-close">
            ✕
        </button>
    </div>

    <div id="drawer-body">

        <!-- aquí luego cargaremos el form con AJAX -->

    </div>

</div>





<?php

$this->registerJs("

/* =========================
   TOGGLE MENU CREAR
========================= */
$(document).on('click', '.create-toggle', function(e){

    e.stopPropagation();

    $('.create-menu').toggleClass('show');

});


/* =========================
   ABRIR DRAWER + CARGAR FORM
========================= */
$(document).on('click', '.drawer-trigger', function(){

    let title = $(this).data('title');
    let url   = $(this).data('url');

    $('#drawer-title').text(title);

    $('#drawer-body').html(
        '<div class=\"drawer-loading\">Cargando...</div>'
    );

    $('.drawer-overlay').addClass('show');
    $('.drawer-panel').addClass('show');

    $('.create-menu').removeClass('show');

    $.get(url, function(response){

        $('#drawer-body').html(response);

    });

});


/* =========================
   CERRAR DRAWER
========================= */
$(document).on('click', '.drawer-close, .drawer-overlay', function(){

    $('.drawer-overlay').removeClass('show');
    $('.drawer-panel').removeClass('show');

});


/* =========================
   CERRAR DROPDOWN AFUERA
========================= */
$(document).on('click', function(e){

    if(!$(e.target).closest('.create-dropdown').length){

        $('.create-menu').removeClass('show');

    }

});


/* =========================
   GUARDAR FORM AJAX
========================= */
$(document).on('beforeSubmit', '#drawer-body form', function(e){

    e.preventDefault();

    let form = $(this);

    $.post(

        form.attr('action'),
        form.serialize(),

        function(response){

            /*
            Formato esperado:
            id|nombre|tipo|mensaje|estado
            */

            if(response.includes('|')){

                let parts = response.split('|');

                let id      = parts[0];
                let nombre  = parts[1];
                let tipo    = parts[2];
                let mensaje = parts[3];
                let estado  = parts[4];


                /* CERRAR DRAWER */
                $('.drawer-overlay').removeClass('show');
                $('.drawer-panel').removeClass('show');


                /* MOSTRAR ALERTA */
                showToast(mensaje, estado);


                /* ACTUALIZAR SELECTS */
                if(tipo === 'curso'){

                    let select = $('#clasesprogramadas-curso_id');

                    if(select.length){

                        select.append(
                            new Option(nombre, id, true, true)
                        );

                        select.trigger('change');

                    }

                }


                if(tipo === 'materia'){

                    let select = $('#clasesprogramadas-materia_id');

                    if(select.length){

                        select.append(
                            new Option(nombre, id, true, true)
                        );

                        select.trigger('change');

                    }

                }


                if(tipo === 'periodo'){

                    let select = $('#clasesprogramadas-periodo_id');

                    if(select.length){

                        select.append(
                            new Option(nombre, id, true, true)
                        );

                        select.trigger('change');

                    }

                }

            }else{

                /*
                Si hay errores de validación,
                Yii devuelve el form con errores
                */
                $('#drawer-body').html(response);

            }

        }

    );

    return false;

});

");
?>




<?php

$this->registerJs("

/* SUBMIT AJAX DRAWER */
$(document).on('beforeSubmit', '#drawer-body form', function(e){

    e.preventDefault();

    let form = $(this);

    $.ajax({

        url: form.attr('action'),
        type: form.attr('method'),
        data: form.serialize(),

        success: function(response){

            // si devuelve nuevamente un form = hubo error
            if($(response).find('form').length){

                let html = $(response).find('form').closest('div');

                $('#drawer-body').html(html);

                return;
            }

            // éxito
            $('.drawer-overlay').removeClass('show');
            $('.drawer-panel').removeClass('show');

            // opcional limpiar
            $('#drawer-body').html('');

            // notificación rápida
            alert('Guardado correctamente');

        },

        error:function(){
            alert('Error al guardar');
        }

    });

    return false;

});

");
?>

<?php

$this->registerJs("

// =========================
// ELIMINAR CON ALERTA02
// =========================
$(document).on('click', '.delete-class', function(e){

    e.preventDefault();
    e.stopPropagation();

    let btn = $(this);
    let url = btn.attr('href');

    $.ajax({

        url: url,
        type: 'POST',

        data:{
            _csrf: yii.getCsrfToken()
        },

        success:function(res){

            showToast(
                res.message,
                res.ok ? 'success' : 'error'
            );

            if(res.ok){

                btn.closest('.class-block').fadeOut(250, function(){

                    $(this).remove();

                });

            }

        },

        error:function(){

            showToast(
                'Error de conexión.',
                'error'
            );

        }

    });

    return false;

});

");



?>






<style>

/* ==========================================
   EJECUTIVA01 — HORARIO CORPORATIVO REAL
========================================== */

:root{

    --bg:#EEF2F6;
    --surface:#FFFFFF;

    --navy:#1F2937;
    --navy-2:#111827;

    --border:#CBD5E1;
    --border-dark:#94A3B8;

    --text:#111827;
    --muted:#6B7280;

    --accent:#334155;

    --success-bg:#ECFDF3;
    --success-text:#166534;

    --warning-bg:#FFF7ED;
    --warning-text:#9A3412;

    --danger-bg:#FEF2F2;
    --danger-text:#991B1B;

}

/* PAGE */
.schedule-page{

    max-width:1800px;
    margin:auto;

    padding:20px;

    background:var(--bg);

    font-family:"Segoe UI", system-ui;
    color:var(--text);

    min-height:100vh;

}


/* ==========================================
   TOP PANEL
========================================== */

.hero-panel{

    display:flex;
    justify-content:space-between;
    align-items:flex-end;

    gap:20px;

    margin-bottom:20px;

    padding:22px;

    background:#FFFFFF;

    border:1px solid var(--border-dark);
    border-radius:5px;

}

.mini-badge{

    display:inline-block;

    padding:5px 10px;

    background:#E5E7EB;

    border:1px solid #D1D5DB;
    border-radius:4px;

    font-size:11px;
    font-weight:700;

    color:#374151;

    margin-bottom:8px;

}

.hero-panel h1{

    margin:0;

    font-size:28px;
    font-weight:700;

    color:var(--navy);

}

.hero-panel p{

    margin:5px 0 0;

    font-size:13px;

    color:var(--muted);

}


/* ==========================================
   ACTIONS
========================================== */

.cp-actions{

    display:flex;
    gap:8px;
    flex-wrap:wrap;

}

.btn-soft{

    border:1px solid #AAB4C0;
    border-radius:4px;

    background:#F8FAFC;

    padding:10px 16px;

    cursor:pointer;

    font-size:12px;
    font-weight:700;

    color:#1F2937;

    transition:.15s ease;

}

.btn-soft:hover{

    background:#E2E8F0;

}


/* ==========================================
   GRID HORARIO
========================================== */

.schedule-grid{

    display:grid;

    grid-template-columns:repeat(6, minmax(180px,1fr));

    gap:12px;

    overflow-x:auto;

    padding-bottom:4px;

}


/* ==========================================
   COLUMNA DEL DÍA
========================================== */

.day-column{

    background:#F8FAFC;

    border:1px solid #BFC9D4;
    border-radius:5px;

    overflow:hidden;

    min-height:700px;

}

.day-header{

    background:#2C3E50;

    color:#FFFFFF;

    padding:12px 14px;

    font-size:12px;
    font-weight:700;

    text-transform:uppercase;
    letter-spacing:.5px;

    border-bottom:1px solid #1E293B;

}


/* ==========================================
   BLOQUE DE CLASE
========================================== */

.class-block{

    background:#FFFFFF;

    border:1px solid #D6DEE8;
    border-radius:5px;

    margin:8px;
    padding:10px;

    transition:.15s ease;

    box-shadow:
        inset 0 1px 0 rgba(255,255,255,.8),
        0 1px 2px rgba(0,0,0,.04);

}

.class-block:hover{

    border-color:#94A3B8;

}


/* ==========================================
   TOP INFO
========================================== */

.class-top{

    display:flex;

    justify-content:space-between;
    align-items:flex-start;

    gap:8px;

    margin-bottom:8px;

}

.class-name{

    font-size:11px;
    font-weight:700;

    line-height:1.3;

    color:#111827;

}


/* ==========================================
   ESTADOS
========================================== */

.class-status{

    display:inline-flex;

    align-items:center;
    justify-content:center;

    min-width:100px;

    padding:4px 10px;

    border-radius:4px;

    white-space:nowrap;

    font-size:10px;
    font-weight:700;

    flex-shrink:0;

}

.class-status.progress{

    background:var(--warning-bg);
    color:var(--warning-text);

}

.class-status.on{

    background:var(--success-bg);
    color:var(--success-text);

}

.class-status.cancel{

    background:var(--danger-bg);
    color:var(--danger-text);

}


/* ==========================================
   HORA
========================================== */

.class-time{

    display:block;

    background:#F1F5F9;

    border:1px solid #CBD5E1;
    border-radius:4px;

    text-align:center;

    padding:6px;

    margin-bottom:8px;

    font-size:11px;
    font-weight:700;

    color:#1E293B;

}


/* ==========================================
   INFO
========================================== */

.class-title{

    font-size:12px;
    font-weight:700;

    color:#111827;

    margin-bottom:4px;

}

.class-sub{

    font-size:11px;

    color:#475569;

    margin-bottom:4px;

}

.class-meta{

    font-size:11px;

    color:#64748B;

    border-top:1px solid #EDF2F7;

    padding-top:6px;

}


/* ==========================================
   ACTION BUTTONS
========================================== */

.class-actions{
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(70px, 1fr));
    gap: 4px;
    margin-top: 10px;
}

.class-actions a{

    text-decoration:none;

    text-align:center;

    padding:6px 4px;

    background:#F8FAFC;

    border:1px solid #CBD5E1;
    border-radius:4px;

    font-size:10px;
    font-weight:700;

    color:#1E293B;

    transition:.15s ease;

}

.class-actions a:hover{

    background:#E2E8F0;

}


/* ==========================================
   EMPTY
========================================== */

.empty-slot{

    padding:25px 10px;

    text-align:center;

    font-size:12px;

    color:#64748B;

}


/* ==========================================
   FAB
========================================== */

.cp-fab{

    position:fixed;

    right:20px;
    bottom:40px;

    padding:12px 18px;

    background:#1F2937;

    border:1px solid #111827;
    border-radius:5px;

    color:white;

    text-decoration:none;

    font-size:13px;
    font-weight:700;

}

.cp-fab:hover{

    background:#111827;

}


/* ==========================================
   RESPONSIVE
========================================== */

@media(max-width:1200px){

    .schedule-grid{

        grid-template-columns:repeat(6, 190px);

    }

}

@media(max-width:900px){

    .hero-panel{

        flex-direction:column;
        align-items:flex-start;

    }

}

@media(max-width:768px){

    .schedule-page{

        padding:12px;

    }

    .hero-panel h1{

        font-size:22px;

    }

}













/* ==========================================
   EJECUTIVA01 — DRAWER CORPORATIVO
========================================== */

/* OVERLAY */
.drawer-overlay{

    position:fixed;
    inset:0;

    background:rgba(15,23,42,.35);

    opacity:0;
    visibility:hidden;

    transition:.18s ease;

    z-index:2000;

}

.drawer-overlay.show{

    opacity:1;
    visibility:visible;

}


/* PANEL */
.drawer-panel{

    position:fixed;

    top:0;
    right:0;

    width:520px;
    max-width:95%;

    height:100vh;

    background:#F8FAFC;

    border-left:1px solid #94A3B8;

    box-shadow:
        -8px 0 20px rgba(15,23,42,.08);

    transform:translateX(100%);

    transition:.22s ease;

    z-index:2001;

    display:flex;
    flex-direction:column;

    font-family:"Segoe UI", system-ui;

}

.drawer-panel.show{

    transform:translateX(0);

}


/* HEADER */
.drawer-header{

    display:flex;

    justify-content:space-between;
    align-items:center;

    padding:18px 20px;

    background:#1F2937;

    border-bottom:1px solid #111827;

}

.drawer-header h3{

    margin:0;

    font-size:14px;
    font-weight:700;

    color:#FFFFFF;

    letter-spacing:.3px;

}


/* CLOSE */
.drawer-close{

    width:34px;
    height:34px;

    border:1px solid #475569;
    border-radius:4px;

    background:#374151;

    color:white;

    cursor:pointer;

    font-size:14px;
    font-weight:700;

    transition:.15s ease;

}

.drawer-close:hover{

    background:#111827;

}


/* BODY */
#drawer-body{

    flex:1;

    overflow-y:auto;

    padding:20px;

    background:#FFFFFF;

}


/* LOADING */
.drawer-loading{

    text-align:center;

    padding:40px 20px;

    color:#64748B;

    font-size:13px;
    font-weight:600;

}





@media print {

    .cp-actions,
    .cp-fab,
    .drawer-overlay,
    .drawer-panel,
    .class-actions {
        display: none !important;
    }

    body {
        background: white !important;
    }

    .class-block {
        break-inside: avoid;
    }

}

</style>