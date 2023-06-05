<?php
require_once '../includes/conexion.php';
//NUEVO REGISTRO EN REVISIONES SIN INCIDENCIAS
// Obtén los datos enviados con la petición POST
$matricula = $_POST['matricula'];
$conductor = $_POST['conductor'];
$noDamage = $_POST['damage'];

// Crear una nueva instancia de conexion
$bbdd = new conexion();
$connection = $bbdd->connect();

// Preparar la consulta SQL para obtener el id del vehiculo y el id del conductor
$stmt = $connection->prepare("SELECT v.idvehiculo, c.idconductor FROM taller.vehiculo v JOIN taller.conductor c ON c.nombre_apellidos = :nombre_apellidos WHERE v.matricula = :matricula");
$stmt->execute([
    'nombre_apellidos' => $conductor,
    'matricula' => $matricula
]);
$result = $stmt->fetch(PDO::FETCH_ASSOC);

// Si no se encontraron resultados, salimos
if (!$result) {
    echo  json_encode(['error' => 'No se encontraron registros de vehículos o conductores.']);
    exit;
}

// Asignamos los ids del vehiculo y el conductor a variables
$idvehiculo = $result['idvehiculo'];
$idconductor = $result['idconductor'];

// Preparar la consulta SQL para insertar en la tabla de revisiones
$stmt = $connection->prepare("INSERT INTO `taller`.`revisiones` (`fecha_revisones`, `descripcion_danio`, `incidencia`, `vehiculo_idvehiculo`, `conductor_idconductor`) VALUES (CURRENT_TIMESTAMP, :descripcion_danio, :incidencia, :vehiculo_idvehiculo, :conductor_idconductor)");

// Ejecutar la consulta SQL con los datos enviados
$stmt->execute([
    'descripcion_danio' => $noDamage,
    'incidencia' => 0, // puedes cambiar esto según tus necesidades
    'vehiculo_idvehiculo' => $idvehiculo,
    'conductor_idconductor' => $idconductor,
]);

?>
