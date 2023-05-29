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
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/reporteCoche.css">    
</head>

<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">Inspección de Taxi</a>
  </nav>

<div class="container mt-4">
     <form class="form-inline" method="post" action="">
      <div class="form-group mb-2">
        <label for="n_licencia" class="sr-only">Licencia</label>
        <input type="text" class="form-control" id="n_licencia" name="n_licencia" placeholder="Introduce la Licencia">
      </div>
      <button type="submit" name="buscar" class="btn btn-primary mb-2">Buscar</button>
    </form>
  </div>
        <?php
            if (isset($_POST['buscar'])) {
                $n_licencia = $_POST['n_licencia'];
            
                try {
                    $bbdd = new conexion();
                    $connection = $bbdd->connect();
                    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                    // Prepare SQL statement
                    $stmt = $connection->prepare("SELECT v.matricula, c.nombre_apellidos, r.descripcion_danio, p.codigo
                    FROM (
                        SELECT vehiculo_idvehiculo, MAX(idhistorial) as max_idhistorial
                        FROM taller.historial_cv
                        GROUP BY vehiculo_idvehiculo
                    ) hv
                    JOIN taller.historial_cv h ON hv.vehiculo_idvehiculo = h.vehiculo_idvehiculo AND hv.max_idhistorial = h.idhistorial
                    JOIN taller.conductor c ON h.conductor_idconductor = c.idconductor
                    JOIN taller.vehiculo v ON h.vehiculo_idvehiculo = v.idvehiculo
                    LEFT JOIN taller.revisiones r ON v.idvehiculo = r.vehiculo_idvehiculo
                    LEFT JOIN taller.incidencia i ON r.idrevisiones = i.revisiones_idrevisiones
                    LEFT JOIN taller.parte p ON i.parte_idparte = p.idparte
                    JOIN taller.licencia l ON v.licencia_idlicencia = l.idlicencia
                    WHERE l.n_licencia = ?;
                    ");

                    // Execute statement
                    $stmt->execute([$n_licencia]);

                    $resultados = $stmt->fetchAll();
                
                    foreach ($resultados as $resultado) {
                        echo '<div class="card mb-3">';
                        echo '<div class="card-body">';
                        echo '<h5 class="card-title">Matrícula del vehículo: ' . $resultado['matricula'] . '</h5>';
                        echo '<p class="card-text">Nombre del conductor: ' . $resultado['nombre_apellidos'] . '</p>';
                        echo '<p class="card-text">Descripción del daño: ' . $resultado['descripcion_danio'] . '</p>';
                        echo '<p class="card-text">Código de parte dañada: ' . $resultado['codigo'] . '</p>';
                        echo '</div>';
                        echo '</div>';
                    }
                    
                    // Create an array to represent the grid
                    $grid = array_fill(0, 6, array_fill(0, 9, ' '));
                    foreach ($resultados as $resultado) {
                        $parte = $resultado['codigo']; // e.g., 'B2'
                        $fila = (int) $parte[1] - 1; // second character converted to zero-based index
                        $columna = ord($parte[0]) - ord('A'); // first character converted to zero-based index
                        $grid[$fila][$columna] = 'X';
                    }

                    // Print the grid
                    echo '<div class="grid-container" style="background-image: url(\'../assets/img/diagramaCoche.jpg\');">';
                    foreach ($grid as $fila => $row) {
                        foreach ($row as $columna => $cell) {
                            if ($cell == 'X') {
                                echo '<div class="damage-indicator" style="grid-row: ' . ($fila + 1) . '; grid-column: ' . ($columna + 1) . ';"></div>';
                            }
                        }
                    }
                    echo '</div>';
                } catch(PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
            }
        ?>
    </form>
</div>

        <form class="contain-form" action="addConductor.php" method="post">
            <label for="nombre">Nombre:</label><br>
            <input type="text" id="nombre" name="nombre"><br>
            <label for="dni">DNI:</label><br>
            <input type="text" id="dni" name="dni"><br>
            <label for="alta_baja">Alta/Baja:</label><br>
            <input type="checkbox" id="alta_baja" name="alta_baja" value="1"><br>
            <input type="submit" value="Añadir Conductor">
        </form>
    </div>
    <!-- Aquí es donde almacenamos los daños que se enviarán al servidor -->
    <form id="damage-form" method="POST" action="submit_damage.php">
    <!-- Información del coche -->
    <input type="hidden" name="car_id" value="id_del_coche">

    <!-- Los daños se añadirán aquí de forma dinámica -->
    <!-- Un daño podría verse así:
    <input type="hidden" name="damages[]" value='{"x": 1, "y": 0, "description": "Daño en el parachoques", "severity": "grave"}'>
    -->
    <div id="car-diagram">
        <img src="../assets/img/frontal.jpg" alt="" style="width:100%">
        <div id="grid">
          <!-- Generamos 6 celdas (3x2) -->
            <?php for ($i = 0; $i < 6; $i++): ?>
                <div class="cell" onclick="reportDamage(<?php echo $i % 3; ?>, <?php echo floor($i / 3); ?>)"></div>
            <?php endfor; ?>
        </div>
    </div>
    <!-- Botón para enviar el formulario -->
    <input type="submit" name="var damages = []" value="Enviar reporte de daños">
    </form>
    
    <script>
    var damages = [];  // Este arreglo almacena todos los daños reportados

    function reportDamage(x, y) {
        // Pregunta por la gravedad del daño
        var damageSeverity = prompt("Por favor, selecciona la gravedad del daño: 1) Moderado, 2) Grave, 3) Muy grave");
        // Pregunta por la descripción del daño
        var damageDescription = prompt("Por favor, describe el daño a la celda (" + x + ", " + y + ")");
        if (damageDescription != null && damageSeverity != null) {
            // Almacena el daño en nuestro arreglo de daños
            damages.push({x: x, y: y, description: damageDescription, severity: damageSeverity});

            // Crea nuevos elementos de entrada en el formulario para este daño
            var form = document.getElementById('damage-form');
            form.innerHTML += '<input type="hidden" name="damages[]" value="' + JSON.stringify(damages[damages.length - 1]) + '">';
        }
    }

    function submitDamages() {
        // Envía el formulario cuando estés listo para enviar los daños al servidor
        document.getElementById('damage-form').submit();

    }
    </script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
