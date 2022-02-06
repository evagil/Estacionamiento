<div class="container">
<form action="<?= base_url('usuarios/administrador/modificar/'.esc($zonas->id_zona_horario)) ?>" method="post" style="width: 50%; margin: 0 auto;">
        <h1>Cambiar datos de la zona</h1>

        <?=form_hidden('id_zona_horario', $zonas->id_zona_horario);?>
        <?=form_hidden('id_horario', $zonas->id_horario);?>
        <?=form_hidden('id_zona', $zonas->id_zona);?>

        <div class="mb-3">
            <label for="costo" class="form-label">Costo</label>
            <input type="text" class="form-control" id="costo" name="costo" value="<?= esc($zonas->costo) ?>">
        </div>


        <div class="mb-3">
            <label for="horario" class="form-label">Horario</label>
            <select id="horario" name="horario" class="form-control">
                <option value="<?= $zonas->id_horario ?>"><?= $zonas->hora_inicio." - ".$zonas->hora_fin ?></option>
            </select>
            <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalHorario">Agregar</a>
        </div>

        <div class="d-flex justify-content-center">
            <input type="submit" class="btn btn-primary" value="Cargar">
        </div>
    </form>

    <div id="resultado_ok" class="alert alert-success alert-dismissible fade show w-50 mt-3 d-none" role="alert"></div>
    <div id="resultado_error" class="alert alert-warning alert-dismissible fade show w-50 mt-3 d-none" role="alert"></div>
</div>

<div class="modal fade" id="modalHorario" aria-labelledby="modalHorarioLabel" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="existenteModelLabel">Agregar un nuevo horario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="hora_inicial" class="form-label">Hora inicial</label>
                    <input type="time" step="2" class="form-control" id="hora_inicial" name="hora_inicial" ?>
                </div>

                <div class="mb-3">
                    <label for="hora_final" class="form-label">Hora final</label>
                    <input type="time" step="2" class="form-control" id="hora_final" name="hora_final" ?>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                <button type="button" class="btn btn-primary" onclick="agregarHorario()">Si</button>
            </div>
        </div>
    </div>
</div>



<script type="text/javascript">
    function agregarHorario() {
        let input = {
            hora_inicio: document.getElementById('hora_inicial').value,
            hora_fin: document.getElementById('hora_final').value,
            dias: '2,3,4,5,6',
        }

        fetch("<?= esc(base_url('usuarios/administrador/agregarHorario')) ?>", { method: 'POST',
            body: JSON.stringify(input)
            })
            .then(response => response.json())
            .then(data => {
                console.log(data)
                if (data.error)
                {
                    console.log(data.error)
                }
                else if (data.ok)
                {
                    cargarHorarios()
                    let mensaje = document.getElementById('resultado_ok')
                    mensaje.innerHTML = data.ok
                    mensaje.classList.remove('d-none')
                    setTimeout(() => {
                        mensaje.classList.remove('d-none')
                    }, 3000)
                }
            })

            
            $("#modalHorario").modal('hide');//ocultamos el modal
            $('body').removeClass('modal-open');//eliminamos la clase del body para poder hacer scroll
            $('.modal-backdrop').remove();//eliminamos el backdrop del moda
            alert("¡Horario generado con exito!");
    }

    function cargarHorarios()
    {
        fetch("<?= esc(base_url('usuarios/administrador/horarios')) ?>", { method: 'GET'})
            .then(response => response.json())
            .then(data => {
                let horaInput = document.getElementById('horario')

                for (let horarios of data.horarios)
                {
                    if (horarios.id_horario != <?= $zonas->id_horario ?>)
                    {
                        let opcion = document.createElement('option')
                        opcion.setAttribute('value', horarios.id_horario)
                        opcion.innerText = horarios.hora_inicio + " - " + horarios.hora_fin
                        horaInput.append(opcion)
                    }
                }
            })
    }

    cargarHorarios()




</script>
