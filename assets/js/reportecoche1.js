
$(document).ready(function() {
    $('#actualizar-button').click(function(e) {
    e.preventDefault();
    $.ajax({
        url: 'update_records.php',
        method: 'post',
        data: {
            matricula: $('#matricula').val(),
            conductor: $('#conductor').val(),
            damage: $('#damage').val()
        },
        dataType: 'json',
        success: function(response) {
            if (response.error) {
                alert(response.error);
            } else {
                // ID de la nueva revisión
                let revisionId = response.nuevaRevisionId;

                // Incidencias (deberías obtener estos datos de tu interfaz de usuario)
                let incidencias = [];  // Modificar esto

                // Enviar las incidencias al servidor
                $.ajax({
                    url: 'insert_incidencias.php',
                    method: 'post',
                    data: {
                        revisionId: revisionId,
                        incidencias: incidencias
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.error) {
                            alert(response.error);
                        } else {
                            alert('Incidencias añadidas correctamente.');
                            // Aquí podrías actualizar tu interfaz de usuario con los nuevos datos
                        }
                    },
                    error: function() {
                        alert('Hubo un error al insertar las incidencias.');
                    }
                });
            }
        },
        error: function() {
            alert('Hubo un error al actualizar los registros.');
        }
    });
});
});