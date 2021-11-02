<!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">


<table class="table table-striped table-sm">
          <thead>
            <tr>
              <th scope="col">Patente</th>
              <th scope="col">Marca</th>
              <th scope="col">Modelo</th>            
              <th scope="col">Opciones</th>
            </tr>
          </thead>
          <tbody>
              <?php
                foreach ($vehiculos as $auto):
                  
              ?>
              <tr>
                  <td><?php echo $auto['patente'] ?></td>
                  <td><?php echo $auto['marca'] ?></td>
                  <td><?php echo $auto['modelo'] ?></td>                               
                  <td> 
                    <a href = "<?php echo base_url('autos/modificar').$auto['id_auto'] ?>" type="button" class="btn btn-primary">Modificar </a>  
                    <a href = "<?php echo base_url('autos/eliminar').$auto['id_auto'] ?>" type="button" class="btn btn-danger">Eliminar</a> 
                  </td> 
                  
              </tr>        
         
          <?php endforeach; ?>
          </tbody>
        </table>