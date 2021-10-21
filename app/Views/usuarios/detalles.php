<div class="card" style="width: 50%; margin: 0 auto">
    <div class="card-header">
        Detalles del Usuario
    </div>
    <div class="card-body">
        <h5 class="card-title">Nombre</h5>
        <p class="card-text"><?= esc($usuario->nombre) ?></p>
        <h5 class="card-title">Apellido</h5>
        <p class="card-text"><?= esc($usuario->apellido) ?></p>
        <h5 class="card-title">Usuario</h5>
        <p class="card-text"><?= esc($usuario->dni) ?></p>
        <h5 class="card-title">Email</h5>
        <p class="card-text"><?= esc($usuario->email) ?></p>
        <h5 class="card-title">Rol</h5>
        <p class="card-text"><?= esc($usuario->nombre_rol) ?></p>
    </div>
    <div class="card-footer text-muted d-flex flex-row justify-content-center">
        <a href="<?php echo base_url('usuarios/modificar').'/'.$usuario->id_usuario ?>" type="button" class="btn btn-primary">Modificar</a>
    </div>
</div>