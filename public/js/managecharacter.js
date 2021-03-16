$(document).ready(function() {
    $('#dataTable').dataTable();

    $("#dataTable").on("click", '#edit_character', function(event) {
        var character_id = $(this).attr("data-id");
        var data_name = $(this).attr("data-name");
        var data_size = $(this).attr("data-size");
        var data_radius = $(this).attr("data-radius");
        var data_altitude = $(this).attr("data-altitude");
        
        $('#character_id').val(character_id);
        $('#name').val(data_name);
        $('#size').val(data_size);
        $('#radius').val(data_radius);
        $('#altitude').val(data_altitude);

        $('#modal_edit_character').modal('show');
    });

    $('#btn_new_resource').on('click', function(event) {
        $('#new_character').modal('show');
    });
});