<div class="table-responsive">

<table class="table table-striped table-sm">

    <thead>
        <tr>
            <th scope="col">Hs Inicio</th>
            <th scope="col">Hs Fin</th>
            <th scope="col">Cantidad de Hs</th>
            <th scope="col">Monto</th>   
            <th scope="col">Usuario</th>   
            <th scope="col">Auto</th>           
            <th scope="col">Zona</th>            
        </tr>
    </thead>
    <tbody>
        <?php foreach ($autos as $vehiculo): ?>
            <tr>
                <td><?php echo $vehiculo->hora_inicio ?></td>
                <td><?php echo $vehiculo->hora_fin ?></td>
                <td><?php echo $vehiculo->cantidad_horas ?></td>
                <td><?php echo $vehiculo->monto ?></td>
                <td><?php echo $vehiculo->id_usuario ?></td>
                <td><?php echo $vehiculo->id_auto ?></td>
                <td><?php echo $vehiculo->id_zona_horario ?></td>        
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
</div>