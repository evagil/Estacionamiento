<div class="container">
<form action="<?= base_url('usuarios/administrador/modificar/'.esc($zonas->id_zona_horario)) ?>" method="post" style="width: 50%; margin: 0 auto;">
        <h1>Cambiar datos de la zona</h1>

        <?=form_hidden('id_zona_horario', $zonas->id_zona_horario);?>
        <?=form_hidden('id_horario', $zonas->id_horario);?>
        <?=form_hidden('id_zona', $zonas->id_zona);?>

        <div class="mb-3">
            <label for="costo" class="form-label">Costo</label>

            <?php if (isset($validacion) && $validacion->hasError('costo')) { ?>
                <span class="text-danger"> <?= "*".$validacion->getError('costo'); ?> </span>
            <?php } ?>

            <input type="text" class="form-control" id="costo" name="costo" value="<?= esc($zonas->costo) ?>">
        </div>


        <div class="mb-3">
            <label for="hora_inicio" class="form-label">Hora Inicial</label>

            <?php if (isset($validacion) && $validacion->hasError('hora_inicio')) { ?>
                <span class="text-danger"> <?= "*".$validacion->getError('hora_inicio'); ?> </span>
            <?php } ?>

            <input type="time" step="2" class="form-control" id="hora_inicio" name="hora_inicio" value="<?= esc($zonas->hora_inicio) ?>">
        </div>


        <div class="mb-3">
            <label for="hora_fin" class="form-label">Hora Inicial</label>

            <?php if (isset($validacion) && $validacion->hasError('hora_fin')) { ?>
                <span class="text-danger"> <?= "*".$validacion->getError('hora_fin'); ?> </span>
            <?php } ?>

            <input type="time" step="2" class="form-control" id="hora_fin" name="hora_fin" value="<?= esc($zonas->hora_fin) ?>">
        </div>

  
     

       
        
        <div class="d-flex justify-content-center">
            <button type="submit" class="btn btn-primary">Cargar</button>
        </div>
    </form>
</div>
