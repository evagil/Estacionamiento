

<div class="container">
    <form style="width: 50%; margin: 0 auto" method="post" action="<?= base_url('usuarios/clientes/saldo') ?>" id="formulario">

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

            <input type="text" class="form-control" id="monto" name="monto" >
        </div>

        
        <div style="text-align: center">
            <input type="submit" class="btn btn-primary" value="cargar" >
        </div>
    </form>
</div>

<script type="text/javascript">
    fetch("<?= esc(base_url('usuarios/clientes/miDinero')) ?>", {
            method: 'GET',
            
        }).then(
            response=> response.json()
        ).then(

             data=> {
               let input=document.getElementById("saldo")
                input.value=data.saldo}
        )


      
</script>




