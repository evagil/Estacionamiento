<div class="table-responsive">
<table class="table table-striped table-sm">
    <thead>
        <tr>
            <th scope="col">Hora de inicio</th>
            <th scope="col">Hora Fin</th>
            <th scope="col">Cantidad de horas</th>
            <th scope="col">Monto</th>
         
        </tr>
    </thead>
    <tbody>

  

    <?php foreach ($ventas as $venta): ?>
    <tr>
        <td><?php echo $venta->hora_inicio ?></td>
        <td><?php echo $venta->hora_fin ?></td>
        <td><?php echo $venta->cantidad_horas ?></td>
        <td><?php echo $venta->monto ?></td>
        
       
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>
</div>

