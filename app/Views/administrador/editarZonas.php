<div class="container">
<form action="<?= base_url('/administrador/modificar/'.esc($zonas->id_zona_horario)) ?>" method="post" style="width: 50%; margin: 0 auto;">
        <h1>Cambiar datos de la zona</h1>

        <?=form_hidden('id_zona_horario', $zonas->id_zona_horario);?>
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>

            <?php if (isset($validacion) && $validacion->hasError('nombre')) { ?>
                <span class="text-danger"> <?= "*".$validacion->getError('nombre'); ?> </span>
            <?php } ?>

            <input type="text" class="form-control" id="nombre" name="nombre" value="<?= esc($zonas->nombre_zona) ?>">
        </div>
        <div class="mb-3">
            <label for="costo" class="form-label">Costo</label>

            <?php if (isset($validacion) && $validacion->hasError('costo')) { ?>
                <span class="text-danger"> <?= "*".$validacion->getError('costo'); ?> </span>
            <?php } ?>

            <input type="text" class="form-control" id="costo" name="costo" value="<?= esc($zonas->costo) ?>">
        </div>
        
        <div class="col">
                <label for="desde">Desde</label>
                <input type="datetime-local" class="form-control" id="desde" name="desde" value="<?= esc($zonas->hora_inicio) ?>">
            </div>
        

        <div class="d-flex justify-content-center">
            <button type="submit" class="btn btn-primary">Cargar</button>
        </div>
    </form>
</div>
