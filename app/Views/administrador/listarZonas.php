<div class="table-responsive">
    <table class="table"
           id="table"
           data-search="true"
           data-pagination="true"
           data-page-size="3"
           data-page-list="[3, 6, 9]">
        <thead>     
        <tr>
            <th data-field="nombre_zona" data-sortable="true">Nombre</th>
            <th data-field="costo" data-sortable="true">Costo</th>
            <th data-field="f_inicio" data-sortable="true">Fecha de inicio</th>
            <th data-field="f_fin" data-sortable="true">Fecha final</th>
            <th data-field="dias" data-sortable="true">Dias</th>
            <th data-field="hora_inicio" data-sortable="true">Hora inicio</th>
            <th data-field="hora_fin" data-sortable="true">Hora fin</th>
            <th data-field="opciones" data-sortable="true">Opciones</th>
        </tr>
        </thead>
    </table>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script type="text/javascript">

    const editar = (id) => {
        window.location.replace("<?= base_url('usuarios/administrador/modificar') ?>/" + id)
    }

    $(document).ready(() => {
        $.ajax({
            method: 'GET',
            url: "<?= esc(base_url('usuarios/administrador/obtenerZonas')) ?>",
            success: (zonas) => {
                $('#table').bootstrapTable({
                    data: zonas,
                    columns: [ {},{},{}, {}, {},{}, {},{
                        align: 'center',
                        formatter : (value,row,index) => {
                            return '' +
                            '<div class="modal fade" id="modalBorrar' + row.id_zona_horario+ '" aria-labelledby="borrarModelLabel" tabindex="-1" aria-hidden="true">' +
                                '<div class="modal-dialog">' +
                                    '<div class="modal-content">' +
                                        '<div class="modal-header">' +
                                            '<h5 class="modal-title" id="borrarModelLabel">Borrar Usuario</h5>' +
                                                '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>' +
                                        '</div>' +
                                        '<div class="modal-body">' +
                                            '<p>¿Esta seguro que desea borrar este usuario?</p>' +
                                        '</div>' +
                                        '<div class="modal-footer">' +
                                            '<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>' +
                                            '<button type="button" class="btn btn-primary" onclick="borrar(' + row.id_usuario + ')">Si</button>' +
                                        '</div>' +
                                    '</div>' +
                                '</div>' +
                            '</div>' +
                            '<button class=\'btn btn-primary m-1 \' id="' + row.id_zona_horario + '" onclick="editar(' + row.id_zona_horario + ')">Editar</button>' 
                        }
                    } ]
                })
            }
        })
    })
</script>






