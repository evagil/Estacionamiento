<div class="container">
    <form action="<?= base_url('/usuarios/modificar/'.esc($usuario->id_usuario)) ?>" method="post" style="width: 50%; margin: 0 auto;">
        <h1>Cambiar datos del usuario</h1>

        <?=form_hidden('id_usuario', $usuario->id_usuario);?>
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>

            <?php if (isset($validacion) && $validacion->hasError('nombre')) { ?>
                <span class="text-danger"> <?= "*".$validacion->getError('nombre'); ?> </span>
            <?php } ?>

            <input type="text" class="form-control" id="nombre" name="nombre" value="<?= esc($usuario->nombre) ?>">
        </div>
        <div class="mb-3">
            <label for="apellido" class="form-label">Apellido</label>

            <?php if (isset($validacion) && $validacion->hasError('apellido')) { ?>
                <span class="text-danger"> <?= "*".$validacion->getError('apellido'); ?> </span>
            <?php } ?>

            <input type="text" class="form-control" id="apellido" name="apellido" value="<?= esc($usuario->apellido) ?>">
        </div>
        <div class="mb-3">
            <label for="dni" class="form-label">DNI</label>

            <?php if (isset($validacion) && $validacion->hasError('dni')) { ?>
                <span class="text-danger"> <?= "*".$validacion->getError('dni'); ?> </span>
            <?php } ?>

            <input type="text" class="form-control" id="dni" name="dni" value="<?= esc($usuario->dni) ?>">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>

            <?php if (isset($validacion) && $validacion->hasError('email')) { ?>
                <span class="text-danger"> <?= "*".$validacion->getError('email'); ?> </span>
            <?php } ?>

            <input type="email" class="form-control" id="email" name="email" value="<?= esc($usuario->email) ?>">
        </div>
        <?php if (session()->get('id_usuario') === $usuario->id_usuario) { ?> <!-- Si soy el dueño de la cuenta -->
            <div class="mb-3">
                <label for="clave" class="form-label">Clave</label>

                <?php if (isset($validacion) && $validacion->hasError('clave')) { ?>
                    <span class="text-danger"> <?= "*".$validacion->getError('clave'); ?> </span>
                <?php } ?>

                <input type="password" class="form-control" id="clave" name="clave" value="<?= esc($usuario->clave) ?>">
            </div>
            <div class="mb-3">
                <label for="confirmarClave" class="form-label">Confirmar Clave</label>

                <?php if (isset($validacion) && $validacion->hasError('confirmarClave')) { ?>
                    <span class="text-danger"> <?= "*".$validacion->getError('confirmarClave'); ?> </span>
                <?php } ?>

                <input type="password" class="form-control" id="confirmarClave" name="confirmarClave">
            </div>
        <?php } else { ?> <!-- Si no soy el dueño de la cuenta, no puedo cambiar la clave, por ej un admin -->
            <?=form_hidden('clave', $usuario->clave);?>
            <?=form_hidden('confirmarClave', $usuario->clave);?>
        <?php } ?>

        <?php if (session()->get('nombre_rol') === 'Administrador' && $rolActual->id_rol != 4): ?>
        <!-- Si se esta logeado como Administrador se puede cambiar roles a todos menos a un Cliente -->
        <div class="mb-3">
            <label for="rol" class="form-label">Rol</label>

            <?php if (isset($validacion) && $validacion->hasError('rol')) { ?>
                <span class="text-danger"> <?= "*".$validacion->getError('rol'); ?> </span>
            <?php } ?>

            <select id="id_rol" class="form-select" name="id_rol">
                <option value="<?= esc($rolActual->id_rol); ?>" selected><?= esc($rolActual->nombre_rol); ?></option>
                <?php foreach ($roles as $rol):
                    if ($rol->id_rol != 4): ?>
                    <option value="<?= esc($rol->id_rol) ?>"><?= esc($rol->nombre_rol) ?></option> <!-- Para que no poder asignar como cliente a un usuario -->
                    <?php endif; ?>
                <?php endforeach; ?>
            </select>
        </div>
        <?php endif; ?>

        <div class="d-flex justify-content-center">
            <button type="submit" class="btn btn-primary">Cargar</button>
        </div>
    </form>
</div>