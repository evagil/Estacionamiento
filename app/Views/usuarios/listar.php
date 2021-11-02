<div class="table-responsive">
<table class="table table-striped table-sm">
    <thead>
        <tr>
            <th scope="col">Nombre</th>
            <th scope="col">Apellido</th>
            <th scope="col">Email</th>
            <th scope="col">DNI</th>
            <th scope="col">Rol</th>
            <th scope="col">Opciones</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($usuarios as $usuario): ?>
    <tr>
        <td><?php echo $usuario->nombre ?></td>
        <td><?php echo $usuario->apellido ?></td>
        <td><?php echo $usuario->email ?></td>
        <td><?php echo $usuario->dni ?></td>
        <td><?php echo $usuario->nombre_rol ?></td>
        <td>
            <a href="<?php echo base_url('usuarios/modificar').'/'.$usuario->id_usuario ?>" type="button" class="btn btn-primary">Modificar</a>
            <a href="<?php echo base_url('usuarios/reestablecer').'/'.$usuario->id_usuario ?>" type="button" class="btn btn-primary">Reest. Clave</a>
            <a href="<?php echo base_url('usuarios/eliminar').'/'.$usuario->id_usuario ?>" type="button" class="btn btn-danger">Eliminar</a>
        </td>
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>
</div>