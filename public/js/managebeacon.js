
$(document).ready(function() {
    $('#beacontable').dataTable();

    $('#beacontable tbody tr').on('click', function( event ) {
        $('#beacon_caracters_table').dataTable().fnDestroy();

        let uuid = this.children[1].textContent;
        let endpoint = 'http://192.168.101.181:8001/beacon/characters/' + uuid;

        $('#beacon_caracters_table').DataTable({
            "ajax":{
                "url": endpoint,
                "dataType": "json",
                "dataSrc": function ( json ) {
                    let characters = json.characters;
                    for (let index = 0; index < characters.length; index ++) {
                        characters[index].no = index + 1;
                    }

                    return characters;
                }
            },
            "columns": [
                {"data": "no"},
                {"data": "name"},
                {"data": "size"},
                {"data": "radius"},
                {"data": "height"}
            ]
        });

        $('#modal_beacons_character').modal('show');
    });

    $("#beacontable").on("click", '#edit_beacon', function(event) {
        var beacon_id = $(this).attr("data-id");
        
        $("#beacon_id").val(beacon_id);
        $("#modal_register_character").modal('show');
    });
});