<br>
    


<form method="post" action="<?= base_url('usuarios/envioPost') ?>">
<input type="text" name="valor1" placeholder="patente">
    <br>
    <br>
    
    <?php if (isset($validacion) && $validacion->hasError('dni')) { ?>
                <span class="text-danger"> <?= "*".$validacion->getError('dni'); ?> </span>
            <?php } ?>


    <div style="text-align: left">
            <button type="submit" class="btn btn-primary">Buscar</button>
        </div>

    
</form>






