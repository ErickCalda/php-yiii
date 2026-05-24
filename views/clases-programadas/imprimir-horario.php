<?php

use yii\helpers\Html;

$models = $dataProvider->getModels();

/* =========================
   MAPEO
========================= */
$horario = [];

$min = 23;
$max = 0;

foreach ($models as $m) {

    $dia = strtolower($m->dia_semana);
    $hora = (int) substr($m->hora_inicio, 0, 2);

    $horario[$hora][$dia][] = $m;

    $min = min($min, $hora);
    $max = max($max, $hora);
}

$dias = ['lunes','martes','miercoles','jueves','viernes'];

/* =========================
   COLORES POR HORA
========================= */
function colorHora($h) {

    $colors = [
        '#f8fafc', '#eef2ff', '#ecfeff',
        '#fef3c7', '#f1f5f9'
    ];

    return $colors[$h % count($colors)];
}
?>

<style>

body {
    font-family: Arial;
    background: #fff;
    margin: 0;
}

/* HEADER */
h2 {
    text-align: center;
    margin: 8px 0;
    font-size: 16px;
}

/* BOTÓN */
.print {
    text-align: center;
    margin-bottom: 6px;
}

.print button {
    padding: 4px 10px;
    font-size: 12px;
}

/* TABLA COMPACTA */
table {
    width: 100%;
    border-collapse: collapse;
    font-size: 11px;
}

th, td {
    border: 1px solid #ddd;
    padding: 3px;
    vertical-align: top;
}

/* HORA */
.hour {
    width: 30px;
    text-align: center;
    font-weight: bold;
}

/* BLOQUE CLASE */
.block {
    background: #fff;
    border-left: 3px solid #333;
    padding: 2px 4px;
    margin-bottom: 2px;
    font-size: 18px;
    line-height: 1.2;
}

/* META */
.meta {
    font-size: 12px;
    color: #000000;
    
}

/* PRINT */
@media print {
    .print {
        display: none;
    }
}

</style>

<h2>HORARIO ACADÉMICO</h2>

<div class="print">
    <button onclick="window.print()">🖨️ Imprimir</button>
</div>

<table>

    <tr>
        <th>Hora</th>

        <?php foreach ($dias as $d): ?>
            <th><?= ucfirst($d) ?></th>
        <?php endforeach; ?>
    </tr>

    <?php for ($h = $min; $h <= $max; $h++): ?>

        <tr style="background: <?= colorHora($h) ?>;">

            <td class="hour">
                <?= sprintf('%02d:00', $h) ?>
            </td>

            <?php foreach ($dias as $d): ?>

                <td>

                    <?php if (!empty($horario[$h][$d])): ?>

                        <?php foreach ($horario[$h][$d] as $c): ?>

                            <div class="block">

                                <strong>
                                    <?= $c->materias->nombre ?? '' ?>
                                </strong>

                                <div class="meta">
                                    <?= $c->cursos->nombre ?? '' ?>
                                </div>

                                <div class="meta">
                                    🧪 <?= $c->laboratorios->nombre ?? '' ?>
                                </div>

                                <div class="meta">
                                    <?= $c->hora_inicio ?>-<?= $c->hora_fin ?>
                                </div>

                            </div>

                        <?php endforeach; ?>

                    <?php endif; ?>

                </td>

            <?php endforeach; ?>

        </tr>

    <?php endfor; ?>

</table>