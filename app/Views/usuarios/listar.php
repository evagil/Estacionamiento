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
        window.location.replace("<?= base_url('usuarios/eliminar') ?>/" + id)
    }

    const reestablecer = (id) => {
        window.location.replace("<?= base_url('usuarios/reestablecer') ?>/" + id)
    }

    const editar = (id) => {
        window.location.replace("<?= base_url('usuarios/modificar') ?>/" + id)
    }

    $(document).ready(() => {
        $.ajax({
            method: 'GET',
            url: "<?= esc(base_url('usuarios/encontrarUsuarios')) ?>",
            success: (usuarios) => {
                $('#table').bootstrapTable({
                    data: usuarios,
                    columns: [ {},{},{}, {}, {}, {
                        align: 'center',
                        formatter : (value,row,index) => {
                            return '<button class=\'btn btn-primary m-1 \' id="' + row.id_usuario + '" onclick="editar(' + row.id_usuario + ')">Editar</button>' +
                                '<button class=\'btn btn-warning m-1 \' id="' + row.id_usuario + '" onclick="reestablecer(' + row.id_usuario + ')">Reest. Clave</button>' +
                                '<button class=\'btn btn-danger m-1 \' id="' + row.id_usuario + '" onclick="editar(' + row.id_usuario + ')">Borrar</button>'
                        }
                    } ]
                })
            }
        })
    })
</script>