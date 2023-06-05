$(document).ready(function() {
    $(".update-button").click(function() {
        var matricula = $(this).data('matricula');
        var conductor = $(this).data('conductor');
        var damage = confirm('¿Hay algún daño en el vehículo?');
        if (damage) {
            $.post("../includes/update_records.php", {
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

    var selectedCell = null;

    $(".grid-cell").click(function() {
        var id = $(this).attr('id');
        selectedCell = $(this);

        var idParts = id.split('-');
        var row = parseInt(idParts[1] + 1);
        var column = String.fromCharCode('a'.charCodeAt(0) + parseInt(idParts[2]) - 1);

        $("#damageModal").modal('show');
    });

    $("#saveDamage").click(function() {
        var damageType = $("input[name='damageType']:checked").val();
        var damageLevel = $("input[name='damageLevel']:checked").val();

        if (damageLevel == "light") {
            selectedCell.addClass('damage-light');
        } else if (damageLevel == "medium") {
            selectedCell.addClass('damage-medium');
        } else if (damageLevel == "heavy") {
            selectedCell.addClass('damage-heavy');
        } else if (damageLevel == "reparado") {
            selectedCell.addClass('damage-reparado');
        }

        $.post("../includes/update_damage.php", {
                cell_id: selectedCell.attr('id'),
                damage_type: damageType,
                damage_level: damageLevel
            })
            .done(function(data) {
                $("#damageModal").modal('hide');
            })
            .fail(function(error) {
                console.log("Error: " + error);
            });
    });
});
