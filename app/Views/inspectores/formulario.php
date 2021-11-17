<div class="w-50" style="margin: auto; text-align: center">
    <form method="post" action="<?= base_url('usuarios/inspectores/envioPost') ?>">
        <?php if (isset($validacion) && $validacion->hasError('patente')) { ?>
            <span class="text-danger"> <?= "*".$validacion->getError('patente'); ?> </span>
        <?php } ?>
        <div class="form-floating mb-3">
            <input type="text" class="form-control" id="valor1" name="valor1" placeholder="Patente">
            <label for="valor1">Patente</label>
        </div>
        <button type="submit" class="btn btn-primary">Buscar</button>
    </form>
</div>