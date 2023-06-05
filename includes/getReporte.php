<?php
require_once '../includes/conexion.php';

$id = $_GET['id'];

$bbdd = new conexion();
$connection = $bbdd->connect();

$stmt = $connection->prepare("SELECT * FROM revisiones WHERE id = :id");
$stmt->execute(['id' => $id]);
$result = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$result) {
    echo  json_encode(['error' => 'No se encontró la revisión.']);
    exit;
}

echo json_encode($result);
?>

