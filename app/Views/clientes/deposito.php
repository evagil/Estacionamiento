

<div class="container">
    <form style="width: 50%; margin: 0 auto" method="post" action="<?= base_url('usuarios/clientes/guardarVehiculo') ?>" id="formulario">

        <div class="mb-3">
            <label for="saldo" class="form-label">Saldo Actual</label>

            <?php if (isset($validacion) && $validacion->hasError('saldo')) { ?>
                <span class="text-danger"> <?= "*".$validacion->getError('saldo'); ?> </span>
            <?php } ?>

            <input type="text" class="form-control" disabled="true" id="saldo" name="saldo" value="<?= old('saldo') ?>">
        </div>

        <div class="mb-3">
            <label for="saldo" class="form-label">Monto a cargar</label>

            <?php if (isset($validacion) && $validacion->hasError('saldo')) { ?>
                <span class="text-danger"> <?= "*".$validacion->getError('saldo'); ?> </span>
            <?php } ?>

            <input type="text" class="form-control" id="saldo" name="saldo" value="<?= old('saldo') ?>">
        </div>

        
        <div style="text-align: center">
            <button type="button" class="btn btn-primary" onclick="cargarSaldo()">Cargar</button>
        </div>
    </form>
</div>

<script type="text/javascript">
    fetch("<?= esc(base_url('usuarios/clientes/saldo')) ?>", {
            method: 'POST',
            
        }).then(
            response=> response.json()
        ).then(

             data=> {
                console.log (data)}
        )


      function cargarSaldo(){

        }
</script>




