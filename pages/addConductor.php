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