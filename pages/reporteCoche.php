<?php
require_once '../includes/conexion.php';

$bbdd = new conexion();
$conexion = $bbdd->connect();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte Coche</title>
</head>

<body>
  <h1>Inspección de Taxi</h1>

  <form method="post" action="">
    <label for="licencia">Licencia:</label>
    <input type="text" id="licencia" name="licencia">
    <input type="submit" name="buscar" value="Buscar">
  </form>
  <?php
    if (isset($_POST['buscar'])) {
        $licencia = $_POST['licencia'];

        $consulta = $conexion->prepare("SELECT * FROM taxis WHERE licencia = :licencia");
        $consulta->bindParam(':licencia', $licencia);
        $consulta->execute();

        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);

        if ($resultado) {
            echo "Taxi encontrado: " . print_r($resultado, true);
        } else {
            echo "No se encontró un taxi con la licencia " . $licencia;
        }
    }
  ?>
    <form action="addConductor.php" method="post">
        <label for="nombre">Nombre:</label><br>
        <input type="text" id="nombre" name="nombre"><br>
        <label for="dni">DNI:</label><br>
        <input type="text" id="dni" name="dni"><br>
        <label for="alta_baja">Alta/Baja:</label><br>
        <input type="checkbox" id="alta_baja" name="alta_baja" value="1"><br>
        <input type="submit" value="Añadir Conductor">
    </form>
    
    <?php
include_once('../includes/conexion.php');

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $conexion = new conexion();
    $con = $conexion->connect();

    $nombre = $_POST['nombre'];
    $dni = $_POST['dni'];
    $alta_baja = $_POST['alta_baja'];

    $sql = "INSERT INTO conductores (nombre, dni, alta_baja) VALUES (?, ?, ?)";
    $stmt= $con->prepare($sql);
    $stmt->execute([$nombre, $dni, $alta_baja]);
}
?>
    

<script src="app.js"></script>
</body>

</html>
