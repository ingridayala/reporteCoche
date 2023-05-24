<?php

require_once '../includes/conexion.php';

$bbdd = new conexion();
$conexion = $bbdd->connect();
$licencia= $_GET['licencia'] ;
$statement = $conexion->prepare("SELECT licencia.n_licencia, vehiculo.matricula, vehiculo.marca, vehiculo.modelo, conductor.nombre_apellidos, conductor.dni_nie
FROM licencia
INNER JOIN vehiculo ON licencia.idlicencia = vehiculo.licencia_idlicencia
INNER JOIN (SELECT * FROM vehiculo_historial_conductor ORDER BY fecha_comienzo DESC) AS vehiculo_historial_conductor 
ON vehiculo.idvehiculo = vehiculo_historial_conductor.vehiculo_idvehiculo
INNER JOIN conductor ON vehiculo_historial_conductor.conductor_idconductor = conductor.idconductor
WHERE licencia.n_licencia = ?
GROUP BY vehiculo.idvehiculo");
$statement->execute([$licencia]);

$results = $statement->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($results);

?>