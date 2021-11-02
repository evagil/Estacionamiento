<div class="table-responsive">
<table class="table table-striped table-sm">
    <thead>
        <tr>
            <th scope="col">Patente</th>
            <th scope="col">Marca</th>
            <th scope="col">Modelo</th>
            <th scope="col">Opciones</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($vehiculos as $auto): ?>
    <tr>
        <td><?php echo $auto->patente?></td>
        <td><?php echo $auto->marca ?></td>
        <td><?php echo $auto->modelo ?></td>       
        <td>
            <a href="<?php echo base_url('autos/modificar').'/'.$auto->id_auto ?>" type="button" class="btn btn-primary">Modificar</a>
            <a href="<?php echo base_url('autos/eliminar').'/'.$auto->id_auto ?>" type="button" class="btn btn-danger">Eliminar</a>
        </td>
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>
</div>