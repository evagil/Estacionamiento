<div class="container">
    <form style="width: 50%; margin: 0 auto" method="post" <?php if (session()->get('nombre_rol') === 'Cliente'): ?>
                                        action="<?= base_url('registro') ?>"
                                    <?php else: ?>
                                        action="<?= base_url('usuarios/alta') ?>"
                                    <?php endif; ?>>
        <h3>Insertar datos del usuario</h3>

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>

            <?php if (isset($validacion) && $validacion->hasError('nombre')) { ?>
                <span class="text-danger"> <?= "*".$validacion->getError('nombre'); ?> </span>
            <?php } ?>

            <input type="text" class="form-control" id="nombre" name="nombre" <?php if ($usuario->nombre) {
                echo "value='$usuario->nombre'";
            } ?>>
        </div>

        <div class="mb-3">
            <label for="apellido" class="form-label">Apellido</label>

            <?php if (isset($validacion) && $validacion->hasError('apellido')) { ?>
                <span class="text-danger"> <?= "*".$validacion->getError('apellido'); ?> </span>
            <?php } ?>

            <input type="text" class="form-control" id="apellido" name="apellido" <?php if ($usuario->apellido) {
                echo "value='$usuario->apellido'";
            } ?>>
        </div>

        <div class="mb-3">
            <label for="dni" class="form-label">DNI</label>

            <?php if (isset($validacion) && $validacion->hasError('dni')) { ?>
                <span class="text-danger"> <?= "*".$validacion->getError('dni'); ?> </span>
            <?php } ?>

            <input type="text" class="form-control" id="dni" name="dni" <?php if ($usuario->dni) {
                echo "value='$usuario->dni'";
            } ?>>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>

            <?php if (isset($validacion) && $validacion->hasError('email')) { ?>
                <span class="text-danger"> <?= "*".$validacion->getError('email'); ?> </span>
            <?php } ?>

            <input type="email" class="form-control" id="email" name="email" <?php if ($usuario->email) {
                echo "value='$usuario->email'";
            } ?>>
        </div>

        <div class="mb-3">
            <label for="clave" class="form-label">Clave</label>

            <?php if (isset($validacion) && $validacion->hasError('clave')) { ?>
                <span class="text-danger"> <?= "*".$validacion->getError('clave'); ?> </span>
            <?php } ?>

            <input type="password" class="form-control" id="clave" name="clave" <?php if ($usuario->clave) echo "value='$usuario->clave'"; ?>>
        </div>

        <div class="mb-3">
            <label for="confirmarClave" class="form-label">Confirmar Clave</label>

            <?php if (isset($validacion) && $validacion->hasError('confirmarClave')) { ?>
                <span class="text-danger"> <?= "*".$validacion->getError('confirmarClave'); ?> </span>
            <?php } ?>

            <input type="password" class="form-control" id="confirmarClave" name="confirmarClave">
        </div>

        <?php if (session()->get('nombre_rol') === 'Administrador'): ?> <!-- Administrador solo asigna un roles Inspector/Vendedor/Administrador -->
        <div class="mb-3">
            <label for="id_rol" class="form-label">Rol</label>
            <?php if (isset($validacion) && $validacion->hasError('rol')) { ?>
                <span class="text-danger"> <?= "*".$validacion->getError('rol'); ?> </span>
            <?php } ?>
            <select id="id_rol" class="form-select" name="id_rol">
                <option value="" selected>Elegir...</option>
                <?php foreach ($roles as $rol): ?>
                    <option value="<?= esc($rol->id_rol) ?>"><?= esc($rol->nombre_rol) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <?php else: ?>
            <?= form_hidden('id_rol', 4); ?>
        <?php endif; ?>

        <div style="text-align: center">
            <button type="submit" class="btn btn-primary">Enviar</button>
        </div>
    </form>
</div>