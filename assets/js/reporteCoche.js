$(document).ready(function() {
    $(".update-button, .noupdate-button").click(function() {
        var matricula = $(this).data('matricula');
        var conductor = $(this).data('conductor');
        var damage = $(this).hasClass('update-button') ? confirm('¿Hay algún daño en el vehículo?') : !confirm('¿Estás seguro que no hay daños en el vehículo?');
        
        console.log(matricula, conductor, damage);  // Console log to verify the values

        $.post("../includes/crear_revision.php", {
                matricula: matricula,
                conductor: conductor,
                damage: damage
            })
            .done(function(data) {
                console.log(data);  // Console log to verify the server response
                alert(damage ? "Registro de revisión e incidencia (si aplica) agregados con éxito." : "Registro de revisión y 0 incidencias (si aplica) agregados con éxito.");
            })
            .fail(function(error) {
                console.error(error);  // Console log to verify the error message
                alert("Hubo un error en la actualización de los registros. Por favor, inténtalo de nuevo.");
            });
    });
    
    
});


