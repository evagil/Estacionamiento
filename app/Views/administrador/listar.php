<div class="table-responsive">
    <table class="table"
           id="table"
           data-search="true"
           data-pagination="true"
           data-page-size="3"
           data-page-list="[3, 6, 9]">
        <thead>
        <tr>
            <th data-field="nombre" data-sortable="true">Nombre</th>
            <th data-field="apellido" data-sortable="true">Apellido</th>
            <th data-field="email" data-sortable="true">Email</th>
            <th data-field="dni" data-sortable="true">DNI</th>
            <th data-field="nombre_rol" data-sortable="true">Rol</th>
            <th data-field="opciones" data-sortable="true">Opciones</th>
        </tr>
        </thead>
    </table>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script type="text/javascript">

    const borrar = (id) => {
        window.location.replace("<?= base_url('usuarios/administrador/eliminar') ?>/" + id)
    }

    const reestablecer = (id) => {
        window.location.replace("<?= base_url('usuarios/administrador/reestablecer') ?>/" + id)
    }

    const editar = (id) => {
        window.location.replace("<?= base_url('usuarios/modificar') ?>/" + id)
    }

    $(document).ready(() => {
        $.ajax({
            method: 'GET',
            url: "<?= esc(base_url('usuarios/administrador/encontrarUsuarios')) ?>",
            success: (usuarios) => {
                $('#table').bootstrapTable({
                    data: usuarios,
                    columns: [ {},{},{}, {}, {}, {
                        align: 'center',
                        formatter : (value,row,index) => {
                            return '' +
                            '<div class="modal fade" id="modalBorrar' + row.id_usuario + '" aria-labelledby="borrarModelLabel" tabindex="-1" aria-hidden="true">' +
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
                            '<button class=\'btn btn-primary m-1 \' id="' + row.id_usuario + '" onclick="editar(' + row.id_usuario + ')">Editar</button>' +
                            '<button class=\'btn btn-warning m-1 \' id="' + row.id_usuario + '" onclick="reestablecer(' + row.id_usuario + ')">Reest. Clave</button>' +
                            '<button class=\'btn btn-danger m-1 \' id="' + row.id_usuario + '" data-bs-toggle="modal" data-bs-target="#modalBorrar' + row.id_usuario + '">Borrar</button>'
                        }
                    } ]
                })
            }
        })
    })
</script>