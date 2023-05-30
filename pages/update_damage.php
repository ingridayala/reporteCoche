<?php
require_once '../includes/conexion.php';

    // Inicia una nueva conexión a la base de datos
    $bbdd = new conexion();
    $connection = $bbdd->connect();

    // Asegúrate de que se envió una celda
    if (!isset($_POST['cell_id']) || !isset($_POST['damage_type']) || !isset($_POST['damage_level'])) {
        echo "Error: No se especificó la celda o el tipo o nivel de daño";
        die();
    }

    // Separa el ID de la celda en fila y columna
    list($ignore, $fila, $columna) = explode('-', $_POST['cell_id']);

    // Convierte la fila y la columna a un código de parte
    // Esto asume que tu código de parte sigue el formato 'A1', 'B2', etc.
    $codigo_parte = chr(ord('A') + $columna) . ($fila + 1);

    // Obtén el tipo y nivel de daño
    $tipo_danio = $_POST['damage_type'];
    $nivel_danio = $_POST['damage_level'];

    // Obtén el ID de la revisión
    // Aquí necesitarás obtener el ID de la revisión actual
    // $revision_id = ...
    
    try {
        // Prepara y ejecuta una consulta SQL para insertar una nueva incidencia
        $stmt = $connection->prepare("INSERT INTO incidencias (parte_idparte, revisiones_idrevisiones, tipo, nivel) VALUES (?, ?, ?, ?)");
        $stmt->execute([$codigo_parte, $revision_id, $tipo_danio, $nivel_danio]);

        echo "Éxito: Incidencia creada";
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
?>
