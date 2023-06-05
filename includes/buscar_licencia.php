<?php

require_once 'conexion.php';
$bbdd = new conexion();
$connection = $bbdd->connect();


function obtenerVehiculos($n_licencia) {
    $bbdd = new conexion();
    $connection = $bbdd->connect();
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    try {
    // Prepare SQL statement
    $stmt = $connection->prepare("SELECT v.matricula, c.nombre_apellidos,r.idrevisiones, r.descripcion_danio, p.codigo
    FROM (
        SELECT vehiculo_idvehiculo, MAX(idhistorial) as max_idhistorial
        FROM taller.historial_cv
        GROUP BY vehiculo_idvehiculo
    ) hv
    JOIN taller.historial_cv h ON hv.vehiculo_idvehiculo = h.vehiculo_idvehiculo AND hv.max_idhistorial = h.idhistorial
    JOIN taller.vehiculo v ON h.vehiculo_idvehiculo = v.idvehiculo
    LEFT JOIN taller.revisiones r ON v.idvehiculo = r.vehiculo_idvehiculo
    LEFT JOIN taller.conductor c ON r.conductor_idconductor = c.idconductor
    LEFT JOIN taller.incidencia i ON r.idrevisiones = i.revisiones_idrevisiones
    LEFT JOIN taller.parte p ON i.parte_idparte = p.idparte
    JOIN taller.licencia l ON v.licencia_idlicencia = l.idlicencia
    WHERE l.n_licencia = ?
    "); 

     $stmt->execute([$n_licencia]);

     $resultados = $stmt->fetchAll();

     // Crea un arreglo para agrupar los daños por matrícula
     $vehiculos = [];

     foreach ($resultados as $resultado) {
         $matricula = $resultado['matricula'];
         if (!isset($vehiculos[$matricula])) {
             // Si este vehículo aún no está en el arreglo, agrégalo
             $vehiculos[$matricula] = [
                 'idrevisiones' => $resultado['idrevisiones'],
                 'nombre_apellidos' => $resultado['nombre_apellidos'],
                 'descripcion_danio' => $resultado['descripcion_danio'],
                 'danios' => []
             ];
         }
         // Agrega el daño a la lista de daños para este vehículo
         $vehiculos[$matricula]['danios'][] = [
             'codigo' => $resultado['codigo']
         ];
     }
     $salida = '';
     //visualiza los datos del vehiculo y el coductor por medio del numero de licencia
     foreach ($vehiculos as $matricula => $vehiculo) {
         $salida .= '<div class="card mb-3">';
         $salida .= '<div class="card-body">';
         $salida .= '<h5 class="card-title">Matrícula del vehículo: ' . $matricula . '</h5>';
         $salida .= '<p class="card-text">Nombre del conductor: ' . $vehiculo['nombre_apellidos'] . '</p>';
         $salida .= '<p class="card-text">ID de revisión: ' . $vehiculo['idrevisiones'] . '</p>';
         $salida .= '<p class="card-text">Descripción del daño: ' . $vehiculo['descripcion_danio'] . '</p>';

         foreach ($vehiculo['danios'] as $dano) {
             
             $salida .= '<p class="card-text">Código de parte dañada: ' . $dano['codigo'] . '</p>';
         }
         //ACTUALIZAR 
         $salida .= '<button class="btn btn-primary update-button" data-matricula="'.$matricula.'" data-conductor="'.$vehiculo['nombre_apellidos'].'">Actualizar</button>';
         $salida .= '<button class="btn btn-primary noupdate-button" data-matricula="'.$matricula.'" data-conductor="'.$vehiculo['nombre_apellidos'].'">No hay cambios</button>';
         $salida .= '</div>';
         $salida .= '</div>';
     }
     echo $salida;

     // Crea un array para representra  grid
     $grid = array_fill(0, 6, array_fill(0, 9, ' '));
     foreach ($resultados as $resultado) {
         $parte = $resultado['codigo']; // e.g., 'B2'
         $fila = (int) $parte[1] - 1; //segundo carácter convertido a índice basado en cero
         $columna = ord($parte[0]) - ord('A'); // primer carácter convertido a índice basado en cero
         $grid[$fila][$columna] = 'X';
     }
     // Print the grid 2
     echo '<div class="grid-container" style="background-image: url(\'../assets/img/diagramaCoche.jpg\');background-size: cover;">';
     foreach ($grid as $fila => $row) {
         foreach ($row as $columna => $cell) {
             // Always add a div for the cell
             echo '<div id="cell-' . $fila . '-' . $columna . '" class="grid-cell';
             if ($cell == 'X') {
                 echo ' damage-indicator';
             }
             echo '" style="grid-row: ' . ($fila + 1) . '; grid-column: ' . ($columna + 1) . ';"></div>';
         }
     }
     echo '</div>';
     } catch (PDOException $e) {
     echo "Error: " . $e->getMessage();
    }
   

    return $vehiculos;}

?>