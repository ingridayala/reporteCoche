<?php
require_once './includes/conexion.php';
require_once './includes/logica.php';

$bbdd = new conexion();
$conexion = $bbdd->connect();

if (isset($_POST['buscar'])) {
    $n_licencia = $_POST['n_licencia'];
    $vehiculos = obtenerVehiculos($n_licencia);
}

include './views/reporteCoche.php';
?>