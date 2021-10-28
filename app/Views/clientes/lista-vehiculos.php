<div class="table-responsive">
    <table class="table"
           id="table"
           data-search="true">
        <thead>
        <tr>
            <th data-field="patente" data-sortable="true">Patente</th>
            <th data-field="marca" data-sortable="true">Marca</th>
            <th data-field="modelo" data-sortable="true">Modelo</th>
        </tr>
        </thead>
    </table>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(() => {
        $.ajax({
            method: 'GET',
            url: "<?= esc(base_url('usuarios/clientes/obtenerVehiculos')) ?>",
            success: (vehiculo) => {
                console.log(vehiculo)
                $('#table').bootstrapTable({
                    data: vehiculo
                });
            }
        })
    })
</script>
