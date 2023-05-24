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
    <link rel="stylesheet" href="../assets/css/reporteCoche.css">    
</head>

<body>
    <h1>Inspección de Taxi</h1>
    <div class="container-form">
        <form class="contain-form" method="post" action="">
            <label for="licencia">Licencia:</label><br>
            <input type="text" id="licencia" name="licencia"><br>
            <input type="submit" name="buscar" value="Buscar">
            <?php
            

                if (isset($_POST['buscar'])) {
                    $licencia = $_POST['licencia'];
                
                    $db = new conexion();
                    $connection = $db->connect();
                
                    // Preparar la consulta SQL
                    $stmt = $connection->prepare("SELECT licencia.n_licencia, vehiculo.matricula, vehiculo.marca, vehiculo.modelo, conductor.nombre_apellidos, conductor.dni_nie
                                                  FROM licencia
                                                  INNER JOIN vehiculo ON licencia.idlicencia = vehiculo.licencia_idlicencia
                                                  INNER JOIN (SELECT * FROM vehiculo_historial_conductor ORDER BY fecha_comienzo DESC) AS vehiculo_historial_conductor 
                                                  ON vehiculo.idvehiculo = vehiculo_historial_conductor.vehiculo_idvehiculo
                                                  INNER JOIN conductor ON vehiculo_historial_conductor.conductor_idconductor = conductor.idconductor
                                                  WHERE licencia.n_licencia = ?
                                                  GROUP BY vehiculo.idvehiculo");
                    // Ejecutar la consulta
                    $stmt->execute([$licencia]);
                
                    // Obtener los resultados
                    $resultados = $stmt->fetchAll();
                
                    // Mostrar los resultados
                    foreach ($resultados as $resultado) {
                        echo 'Licencia: ' . $resultado['n_licencia'] . '<br>';
                        echo 'Matrícula del vehículo: ' . $resultado['matricula'] . '<br>';
                        echo 'Marca del vehículo: ' . $resultado['marca'] . '<br>';
                        echo 'Modelo del vehículo: ' . $resultado['modelo'] . '<br>';
                        echo 'Nombre del conductor: ' . $resultado['nombre_apellidos'] . '<br>';
                        echo 'DNI del conductor: ' . $resultado['dni_nie'] . '<br>';
                    }
                }
                
            ?>
        </form>
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
</body>
</html>
