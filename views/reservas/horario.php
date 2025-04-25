<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\models\Reservas;

$this->title = 'Horario de Reservas';
$this->params['breadcrumbs'][] = $this->title;

$dias = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes'];
$horas = [
    '07:00', '08:00', '09:00', '10:00', '11:00', '12:00', 
    '13:00', '14:00', '15:00', '16:00', '17:00', '18:00'
];

$reservas = Reservas::find()->where(['estado' => 'aprobada'])->all();

function buscarReserva($reservas, $dia, $hora) {
    foreach ($reservas as $reserva) {
        $fecha = strtotime($reserva->fecha);
        $diaSemana = date('N', $fecha); // 1 (lunes) a 5 (viernes)
        $horaInicio = strtotime($reserva->hora_inicio);
        $horaFin = strtotime($reserva->hora_fin);
        $horaActual = strtotime($hora);

        if ($diaSemana == ($dia + 1) && $horaActual >= $horaInicio && $horaActual < $horaFin) {
            return $reserva;
        }
    }
    return null;
}

?>

<div class="reservas-horario">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="table-responsive">
        <table class="table table-bordered text-center align-middle shadow">
            <thead class="table-dark">
                <tr>
                    <th>Hora</th>
                    <?php foreach ($dias as $dia): ?>
                        <th><?= $dia ?></th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($horas as $hora): ?>
                    <tr>
                        <td class="fw-bold bg-light"><?= $hora ?></td>
                        <?php for ($i = 0; $i < 5; $i++): ?>
                            <?php $reserva = buscarReserva($reservas, $i, $hora); ?>
                            <td class="<?= $reserva ? 'bg-success-subtle text-dark' : 'bg-body-secondary' ?>">
                                <?php if ($reserva): ?>
                                    <div style="font-size: 14px;">
                                        <i class="bi bi-person-fill"></i>
                                        <?= Html::encode($reserva->usuario->nombre ?? 'Usuario desconocido') ?><br>
                                        <i class="bi bi-cpu-fill"></i>
                                        <small><?= Html::encode($reserva->laboratorio->nombre ?? 'Laboratorio') ?></small>
                                    </div>
                                <?php else: ?>
                                    <span style="color: #bbb;">—</span>
                                <?php endif; ?>
                            </td>
                        <?php endfor; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Estilos -->
<style>
    .reservas-horario {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        padding: 30px;
        background: #f4f6f9;
    }

    .table thead th {
        background-color: #2c3e50;
        color: #ffffff;
        font-size: 16px;
        text-transform: uppercase;
    }

    .table td {
        vertical-align: middle;
        padding: 10px 5px;
    }

    .table td.bg-success-subtle {
        background-color: #d1f0d1 !important;
    }

    .table td.bg-body-secondary {
        background-color: #eeeeee !important;
    }

    .table-responsive {
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }

    i.bi {
        margin-right: 4px;
        color: #555;
    }
</style>

<!-- Bootstrap Icons (asegúrate de incluir esto en tu layout principal o aquí si es necesario) -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
