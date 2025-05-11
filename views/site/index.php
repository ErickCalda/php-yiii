<?php

use yii\helpers\Html;

/** @var yii\web\View $this */

$this->title = Yii::t('app', 'Dashboard');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-dashboard">

    <!-- Título Principal -->
    <h1 class="dashboard-title"><?= Html::encode($this->title) ?></h1>

    <!-- Paneles Interactivos -->
    <div class="row">
        <div class="col-md-4">
            <div class="dashboard-card bg-info" id="entrada-materiales">
                <h4><?= Yii::t('app', 'Entradas de Materiales') ?></h4>
                <p>20 Nuevas entradas</p>
                <a href="#" class="btn btn-light btn-sm"><?= Yii::t('app', 'Ver Más') ?></a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="dashboard-card bg-success" id="bitacoras">
                <h4><?= Yii::t('app', 'Bitácoras') ?></h4>
                <p>15 Nuevas bitácoras</p>
                <a href="#" class="btn btn-light btn-sm"><?= Yii::t('app', 'Ver Más') ?></a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="dashboard-card bg-warning" id="tareas-pendientes">
                <h4><?= Yii::t('app', 'Tareas Pendientes') ?></h4>
                <p>5 Tareas por revisar</p>
                <a href="#" class="btn btn-light btn-sm"><?= Yii::t('app', 'Ver Más') ?></a>
            </div>
        </div>
    </div>

    <!-- Gráfico de Progreso -->
    <div class="row">
        <div class="col-md-12">
            <div class="dashboard-card bg-white">
                <h4><?= Yii::t('app', 'Progreso de Tareas') ?></h4>
                <div id="progress-chart" style="height: 300px;"></div>
            </div>
        </div>
    </div>

    <!-- Panel Expansible para Tareas Detalladas -->
    <div class="row">
        <div class="col-md-12">
            <div class="dashboard-card bg-white">
                <h4><?= Yii::t('app', 'Tareas Pendientes Detalladas') ?></h4>
                <button class="btn btn-light btn-sm" onclick="toggleDetails()">Mostrar Detalles</button>
                <div id="task-details" style="display: none;">
                    <ul>
                        <li><?= Yii::t('app', 'Tarea 1') ?></li>
                        <li><?= Yii::t('app', 'Tarea 2') ?></li>
                        <li><?= Yii::t('app', 'Tarea 3') ?></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Notificaciones Sutiles -->
    <div class="row">
        <div class="col-md-12">
            <div class="dashboard-notification bg-danger">
                <p><strong>Alerta:</strong> Tienes nuevas tareas pendientes.</p>
            </div>
        </div>
    </div>

</div>

<!-- Estilos CSS -->
<style>
    .site-dashboard {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color:trasparet;
        padding: 30px;
        border-radius: 8px;
    }

    .dashboard-title {
        color: #2c3e50;
        font-weight: bold;
        margin-bottom: 30px;
    }

    .dashboard-card {
        background-color: #ffffff;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
        text-align: center;
        transition: transform 0.3s ease;
    }

    .dashboard-card:hover {
        transform: scale(1.03);
    }

    .dashboard-card h4 {
        color: #2c3e50;
        font-size: 18px;
        margin-bottom: 10px;
    }

    .dashboard-card p {
        color: #7f8c8d;
        font-size: 16px;
        margin-bottom: 15px;
    }

    .dashboard-card a {
        text-decoration: none;
        color: #3498db;
        font-weight: bold;
    }

    .dashboard-card a:hover {
        color: #2980b9;
    }

    .bg-info {
        background-color: #3498db;
    }

    .bg-success {
        background-color: #2ecc71;
    }

    .bg-warning {
        background-color: #f39c12;
    }

    .bg-white {
        background-color: #ffffff;
    }

    .dashboard-notification {
        background-color: #e74c3c;
        color: #fff;
        padding: 15px;
        border-radius: 8px;
        margin-top: 20px;
        text-align: center;
    }

    /* Estilo de gráfico */
    #progress-chart {
        background-color: #ecf0f1;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    /* Estilo del Panel Expansible */
    #task-details {
        margin-top: 15px;
        font-size: 14px;
        color: #7f8c8d;
    }

</style>

<!-- Scripts para Interactividad -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    // Gráfico de Progreso
    var options = {
        chart: {
            type: 'radialBar',
            height: 300
        },
        series: [70],
        labels: ['Progreso'],
        plotOptions: {
            radialBar: {
                track: {
                    background: '#e0e0e0'
                },
                dataLabels: {
                    name: {
                        fontSize: '16px',
                        color: '#333'
                    },
                    value: {
                        fontSize: '22px',
                        color: '#333'
                    }
                }
            }
        }
    };
    var chart = new ApexCharts(document.querySelector("#progress-chart"), options);
    chart.render();

    // Función para mostrar/ocultar detalles de tareas
    function toggleDetails() {
        var details = document.getElementById("task-details");
        if (details.style.display === "none") {
            details.style.display = "block";
        } else {
            details.style.display = "none";
        }
    }
</script>
