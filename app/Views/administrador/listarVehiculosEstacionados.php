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
            <th data-field="venta" data-sortable="true">Por Vendedor</th>
            <th data-field="pago" data-sortable="true">Pago</th>
            <th data-field="patente" data-sortable="true">Auto</th>
            <th data-field="nombre_zona" data-sortable="true">Zona</th>
        </tr>
        </thead>
    </table>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script type="text/javascript">    

    $(document).ready(() => {
        $.ajax({
            method: 'GET',
            url: "<?= esc(base_url('usuarios/administrador/obtenerVehiculosEstacionados')) ?>",
            success: (vehiculos) => {
                $('#table').bootstrapTable({
                    data: vehiculos
                })
            }
        })
    })
</script>