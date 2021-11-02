<div class="card" style="width: 50%; margin: 0 auto">
    <div class="card-header">
        Detalles del Vehiculo
    </div>
    <div class="card-body">
        <h5 class="card-title">Patente</h5>
        <p class="card-text"><?= esc($auto->patente) ?></p>
        <h5 class="card-title">Marca</h5>
        <p class="card-text"><?= esc($auto->marca) ?></p>
        <h5 class="card-title">Modelo</h5>
        <p class="card-text"><?= esc($auto->modelo) ?></p>        
    </div>
    <div class="card-footer text-muted d-flex flex-row justify-content-center">
        <a href="<?php echo base_url('vehiculos/modificar').'/'.$auto->id_auto ?>" type="button" class="btn btn-primary">Modificar</a>
    </div>
</div>