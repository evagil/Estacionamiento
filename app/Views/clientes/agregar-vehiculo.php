<div class="container">
    <form style="width: 50%; margin: 0 auto" method="post" action="<?= base_url('usuarios/clientes/guardarVehiculo') ?>" id="formulario">
        <h3>Insertar datos del Vehiculo</h3>

        <div class="mb-3">
            <label for="patente" class="form-label">Patente</label>

            <?php if (isset($validacion) && $validacion->hasError('patente')) { ?>
                <span class="text-danger"> <?= "*".$validacion->getError('patente'); ?> </span>
            <?php } ?>

            <input type="text" class="form-control" id="patente" name="patente" value="<?= old('patente') ?>">
        </div>

        <div class="mb-3">
            <label for="marca" class="form-label">Marca</label>

            <?php if (isset($validacion) && $validacion->hasError('marca')) { ?>
                <span class="text-danger"> <?= "*".$validacion->getError('marca'); ?> </span>
            <?php } ?>

            <input type="text" class="form-control" id="marca" name="marca" value="<?= old('marca') ?>">
        </div>

        <div class="mb-3">
            <label for="modelo" class="form-label">Modelo</label>

            <?php if (isset($validacion) && $validacion->hasError('modelo')) { ?>
                <span class="text-danger"> <?= "*".$validacion->getError('modelo'); ?> </span>
            <?php } ?>

            <input type="text" class="form-control" id="modelo" name="modelo" value="<?= old('modelo') ?>">
        </div>

        <div style="text-align: center">
            <button type="button" class="btn btn-primary" onclick="existeAuto()">Enviar</button>
        </div>
    </form>
</div>

<!-- Modal (existe vehiculo) -->
<div class="modal fade" id="modalExistePatente" aria-labelledby="existenteModelLabel" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="existenteModelLabel">Patente Existente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>La patente ingresada ya se encuentra agregada. ¿Desea utilizar ese vehiculo?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                <button type="button" class="btn btn-primary" onclick="vincularVehiculo()">Si</button>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script type="text/javascript">
    let myModal = new bootstrap.Modal(document.getElementById('modalExistePatente'), {
        keyboard: false
    })

    const existeAuto = () => {
        let patente = document.getElementById('patente').value
        let formulario = document.getElementById('formulario')

        $(document).ready(() => {
            $.ajax({
                method: 'GET',
                url: "<?= esc(base_url('usuarios/clientes/obtenerVehiculos')) ?>/" + patente,
                success: (response) => {
                    if (response) {
                        myModal.show()
                    }
                    else {
                        formulario.submit()
                    }
                }
            })
        })
    }

    const vincularVehiculo = () => {
        let patente = document.getElementById('patente').value
        window.location.replace("<?= esc(base_url('usuarios/clientes/vincularVehiculo')) ?>/" + patente)
    }

</script>