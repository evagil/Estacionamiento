<br>
<!DOCTYPE html>   


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



     


<!--

<html>
<head>

   <style>
    .habilitado{  
    display: block;
    }

    .oculto{
      visibility: hidden;
     }
   </style> 

    </head>
   <body>
                <div>
                <input id="check" class="habilitado" onchange="habilitar()" type="checkbox">
                <input id="toggle" type="time" min="10">
                </div>


<script type="text/javascript">
        let toggle = document.getElementById('toggle');
        let check = document.getElementById('check');

        const habilitar = () => {
           if (toggle.classList.contains('habilitado'))
             {
                toggle.classList.remove('habilitado')
                 toggle.classList.add('oculto')
             
              }
           else
              {
                       toggle.classList.remove('oculto')
                       toogle.classList.add('habilitado')
               }
          } 
</script>

 </body>
 </html>


 -->