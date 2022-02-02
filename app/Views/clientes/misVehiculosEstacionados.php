

<div class="table-responsive">
    <table class="table"
           id="table"
           data-search="true"
           data-pagination="true"
           data-page-size="3"
           data-page-list="[3, 6, 9]">
        <thead>
        <tr>
            <th data-field="hora_inicio" data-sortable="true">Hora Inicio</th>
            <th data-field="hora_fin" data-sortable="true">Hora Fin</th>
            <th data-field="cantidad_horas" data-sortable="true">Cantidad Hs</th>
            <th data-field="monto" data-sortable="true">Monto</th>
            <th data-field="estado" data-sortable="true">Estado</th>
            <th data-field="nombre_usuario" data-sortable="true">Usuario</th>
            <th data-field="pago" data-sortable="true">Pago</th>
            <th data-field="patente" data-sortable="true">Auto</th>
            <th data-field="nombre_zona" data-sortable="true">Zona</th>
        </tr>
        </thead>
    </table>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script type="text/javascript">
    const finalizarVenta = (idVenta) => {
        window.location.replace("<?= esc(base_url('usuarios/clientes/finalizarEstadia')) ?>/" + idVenta)
    }

    $(document).ready(() => {
        $.ajax({
            method: 'GET',
            url: "<?= esc(base_url('usuarios/clientes/obtenerEstadiaVehiculo')) ?>",
            success: (vehiculos) => {
                $('#table').bootstrapTable({
                    data: vehiculos,
                    columns: [{}, {
                        field: 'hora_fin',
                        title: 'Hora Fin',
                        align: 'center',
                        valign: 'middle',
                        formatter: (value, row, index) => {
                            if (row.estado === 'Activo' && row.hora_fin === null) {
                                return '<button class=\'btn btn-danger \' onclick="finalizarVenta(' + row.id_venta + ')">Finalizar</button> '
                            }
                            else
                            {
                                return row.hora_fin
                            }
                        }
                    }, {}, {}, {}, {}, {}, {}]
                })
            }
        })
    })
</script>
