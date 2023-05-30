<?php
require 'conexion.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$conexion = new conexion();
$conn = $conexion->connect();
$_SESSION['vehiculos'] = $vehiculos;

// Recoge los datos del POST
$matricula = $_POST['matricula'];
$conductor = $_POST['conductor_idconductor'];
$vehiculo = $_POST['vehiculo_idvehiculo'];
$descripcion_danio = $_POST['descripcion_danio'];
$incidencia = $_POST['incidencia'];

// Crear una nueva revisión con la misma matrícula y los datos del conductor
$query = "INSERT INTO revisiones (fecha_revisiones, descripcion_danio, incidencia, vehiculo_idvehiculo, conductor_idconductor) 
          VALUES (NOW(), '$descripcion_danio', $incidencia, $vehiculo, $conductor)";
$stmt = $conn->prepare($query);
$stmt->execute([$descripcion_danio, $incidencia, $vehiculo, $conductor]);

echo 'Registro de revisión actualizado correctamente.';
?>
