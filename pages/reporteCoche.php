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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
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
    require_once '../includes/logica.php';
    if (isset($_POST['buscar'])) {
        $n_licencia = $_POST['n_licencia'];
        $vehiculos = obtenerVehiculos($n_licencia);
        //mediente el numero de numero de licencia obtenemos todos los datos del vehiculo y el conductor 
    }
    ?>
    
    <script>
        $(document).ready(function() {
            $(".update-button").click(function() {
                var matricula = $(this).data('matricula');
                var conductor = $(this).data('conductor');
                var damage = confirm('¿Hay algún daño en el vehículo?');
                if (damage) {
                    // Enviar una solicitud AJAX para crear los registros necesarios
                    $.post("update_records.php", {
                            matricula: matricula,
                            conductor: conductor,
                            damage: damage
                        })
                        .done(function(data) {
                            alert("Registro de revisión e incidencia (si aplica) agregados con éxito.");
                        })
                        .fail(function(error) {
                            alert("Hubo un error en la actualización de los registros. Por favor, inténtalo de nuevo.");
                        });
                }
            });
        });
    </script>
    </form>
    <!-- Modal -->
    <div class="modal fade" id="damageModal" tabindex="-1" role="dialog" aria-labelledby="damageModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="damageModalLabel">Seleccionar daño</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h6>Tipo de daño</h6>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="damageType" id="scratch" value="scratch">
                        <label class="form-check-label" for="scratch">Arañazo</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="damageType" id="scuff" value="scuff">
                        <label class="form-check-label" for="scuff">Rozadura</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="damageType" id="hit" value="hit">
                        <label class="form-check-label" for="hit">Golpe</label>
                    </div>
                    <h6>Nivel de daño</h6>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="damageLevel" id="light" value="light">
                        <label class="form-check-label" for="light">Leve</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="damageLevel" id="medium" value="medium">
                        <label class="form-check-label" for="medium">Medio</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="damageLevel" id="heavy" value="heavy">
                        <label class="form-check-label" for="heavy">Grave</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="damageLevel" id="reparado" value="reparado">
                        <label class="form-check-label" for="reparado">Reparado</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" id="saveDamage">Guardar</button>
                </div>
            </div>
        </div>

    </div>
    
    <script>
        $(document).ready(function() {
            var selectedCell = null;

            $(".grid-cell").click(function() {
                var id = $(this).attr('id');
                selectedCell = $(this);

                var idParts = id.split('-');
                var row = parseInt(idParts[1] + 1);
                var column = String.fromCharCode('a'.charCodeAt(0) + parseInt(idParts[2]) - 1);

                console.log("Cell clicked: " + id);
                console.log("Row: " + row + ", Column: " + column);

                // Muestra la modal
                $("#damageModal").modal('show');
            });

            $("#saveDamage").click(function() {
                // Obtiene el tipo y nivel de daño seleccionado
                var damageType = $("input[name='damageType']:checked").val();
                var damageLevel = $("input[name='damageLevel']:checked").val();

                console.log("Damage type: " + damageType);
                console.log("Damage level: " + damageLevel);

                // Actualiza el color de la celda seleccionada basado en el nivel de daño
                if (damageLevel == "light") {
                    selectedCell.addClass('damage-light');
                } else if (damageLevel == "medium") {
                    selectedCell.addClass('damage-medium');
                } else if (damageLevel == "heavy") {
                    selectedCell.addClass('damage-heavy');
                } else if (damageLevel == "reparado") {
                    selectedCell.addClass('damage-reparado');
                }

                // Envía la información al servidor
                $.post("update_damage.php", {
                        cell_id: selectedCell.attr('id'),
                        damage_type: damageType,
                        damage_level: damageLevel
                    })
                    .done(function(data) {
                        console.log("Data Loaded: " + data);
                        // Cierra la modal
                        $("#damageModal").modal('hide');
                    })
                    .fail(function(error) {
                        console.log("Error: " + error);
                    });
            });
        });
    </script>
    
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

</body>

</html>