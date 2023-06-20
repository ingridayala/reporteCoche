<?php
require_once '../includes/conexion.php';

if (!isset($_POST['matricula']) || !isset($_POST['conductor']) || !isset($_POST['damage'])) {
    echo json_encode(['error' => 'Faltan datos en la petición.']);
    exit;
}

// Obtén los datos enviados con la petición POST
$matricula = $_POST['matricula'];
$conductor = $_POST['conductor'];
//$damage = $_POST['damage']; // Esto puede ser verdadero o falso
$damage = filter_var($_POST['damage'], FILTER_VALIDATE_BOOLEAN);

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
$stmt = $connection->prepare("INSERT INTO `taller`.`revisiones` (`fecha_revisiones`, `descripcion_danio`, `incidencia`, `vehiculo_idvehiculo`, `conductor_idconductor`) VALUES (CURRENT_TIMESTAMP, :descripcion_danio, :incidencia, :vehiculo_idvehiculo, :conductor_idconductor)");

// Si damage es verdadero, hay daño. En caso contrario, no hay daño.
$descripcion_danio = $damage ? "Hay daño en el vehículo" : "No hay daño en el vehículo"; // Puedes cambiar estas descripciones según tus necesidades
$incidencia = $damage ? 1 : 0;

// Ejecutar la consulta SQL con los datos enviados
$stmt->execute([
    'descripcion_danio' => $descripcion_danio,
    'incidencia' => $incidencia,
    'vehiculo_idvehiculo' => $idvehiculo,
    'conductor_idconductor' => $idconductor,
]);

if ($stmt->rowCount() > 0) {
    $nuevaRevisionId = $connection->lastInsertId();
    echo json_encode(['nuevaRevisionId' => $nuevaRevisionId]);
    echo $damage ? 'Registro de revisión e incidencia agregados con éxito.' : 'Registro de revisión y 0 incidencias agregados con éxito.';
} else {
    echo json_encode(['error' => 'No se pudo insertar la nueva revisión.']);
}
?>
