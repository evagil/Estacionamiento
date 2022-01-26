<div class="d-flex flex-row justify-content-center">
    <form id="formulario" class="w-50 text-center" method="post" action="<?= base_url('usuarios/inspectores/infraccion') ?>">
        <?php if (isset($validacion) && $validacion->hasError('patente')) { ?>
            <span class="text-danger"> <?= "*".$validacion->getError('patente'); ?> </span>
        <?php } ?>
        <div class="input-group mb-3">
            <span class="input-group-text">Patente</span>
            <?php if (isset($patente)): ?>
                <input type="text" class="form-control" id="patente" name="patente" value="<?= $patente ?>" readonly>
            <?php else: ?>
                <input type="text" class="form-control" id="patente" name="patente" value="<?= old('patente') ?>" autocomplete="off">
            <?php endif; ?>

            <span class="input-group-text d-none" id="loading">
                <span class="spinner-border spinner-border-sm" role="status"></span>
            </span>
            <span class="valid-feedback">
                Patente existente
            </span>
            <span class="invalid-feedback">
                No existe la Patente <a class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modalCarga">Crear</a>
            </span>
        </div>

        <div class="input-group mb-3">
            <span class="input-group-text">Descripcion</span>
            <textarea rows=3 class="form-control" id="descripcion" name="descripcion"><?= old('descripcion') ?></textarea>
        </div>

        <input id="submit" type="submit" class="btn btn-primary" value="Enviar" disabled>
    </form>
</div>

<!-- Modal (carga vehiculo) -->
<div class="modal fade" id="modalCarga" aria-labelledby="cargaModelLabel" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="previsualizacionModelLabel">Carga Vehiculo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h3>No existe vehiculo con esta patente, ¿desea agregarlo?</h3>
                <form id="formCarga">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="marca" name="marca">
                        <label for="marca">Marca</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="modelo" name="modelo">
                        <label for="modelo">Modelo</label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                <button type="button" data-bs-dismiss="modal" class="btn btn-primary" onclick="cargarVehiculo()">Guardar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal (errores) -->
<div class="modal fade" id="modalErrores" aria-labelledby="erroresModelLabel" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="erroresModelLabel">Carga Vehiculo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="errorsBody">

            </div>
            <div class="modal-footer text-center">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script type="text/javascript">
    const patente = document.getElementById('patente')
    const loading = document.getElementById('loading')
    const submit = document.getElementById('submit')
    const modalErrores = new bootstrap.Modal(document.getElementById('modalErrores'))

    patente.addEventListener('change', validarPatente)

    function validarPatente() {
        submit.disabled = true
        patente.classList.remove('is-valid')
        patente.classList.remove('is-invalid')
        loading.classList.remove('d-none')

        fetch(
            "<?= esc(base_url('usuarios/inspectores/auto')) ?>/" + patente.value,
            { method: 'GET' }
        ).then(response => response.json()).then(data => {
            loading.classList.add('d-none')
            if (data.auto) {
                patente.classList.add('is-valid')
                submit.disabled = false
            }
            else {
                patente.classList.add('is-invalid')
            }
        })
    }

    function cargarVehiculo() {
        let valorPatente = patente.value
        let formData = new FormData(document.getElementById('formCarga'))
        formData.append('patente', valorPatente)

        let errorMensaje = document.querySelectorAll('.errorMensaje')
        for (let elemento of errorMensaje)
        {
            elemento.parentNode.removeChild(elemento)
        }

        fetch("<?= base_url('usuarios/inspectores/guardarVehiculo') ?>", {
            method: 'POST',
            body: formData
        })
            .then(response => {
                if (response.status == 200)
                {
                    validarPatente()
                }
                else
                {
                    return response.json()
                }
            })
            .then(data => {
                if (data)
                {
                    let errorContainer = document.getElementById('errorsBody')

                    for (let llave in data)
                    {
                        let div = document.createElement('div')
                        div.classList.add('errorMensaje')
                        div.classList.add('alert')
                        div.classList.add('alert-danger')
                        div.setAttribute('role', 'alert')
                        div.textContent = data[llave]
                        errorContainer.appendChild(div)
                    }

                    modalErrores.show()
                }
            })
    }
</script>

<!-- Valida la patente que se agrego via PHP -->
<?php if (isset($patente)):
    echo "<script> validarPatente() </script>";
endif; ?>
