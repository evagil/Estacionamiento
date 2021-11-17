<br>



<form method="post" action="<?= base_url('usuarios/inspectores/envioPost') ?>">
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



<script type="text/javascript">
    function showContent() {
        element = document.getElementById("content");
        check = document.getElementById("check");
        if (check.checked) {
            element.style.display='block';
        }
        else {
            element.style.display='none';
        }
    }
</script>

<b>Mostrar contenido?</b>
<input type="checkbox" name="check" id="check" value="1" onchange="javascript:showContent()" />

<div id="content" style="display: none;">
   contenido del div escondido<br/>
   contenido del div escondido<br/>
   contenido del div escondido<br/>
 </div>