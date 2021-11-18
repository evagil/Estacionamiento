<link rel="stylesheet" href="https://uicdn.toast.com/tui.time-picker/latest/tui-time-picker.css">
<link rel="stylesheet" href="https://uicdn.toast.com/tui.date-picker/latest/tui-date-picker.css">




<div class="container">
    <form style="width: 50%; margin: 0 auto" id="formulario" method="post" action="<?= base_url('usuarios/clientes/crear') ?>">
        <h3>Insertar datos de la estadia</h3>

        <?php if (isset($validacion) && $validacion->hasError('patente')) { ?>
            <span class="text-danger"> <?= "*".$validacion->getError('patente'); ?> </span>
        <?php } ?>
        <div id="seleccionPatente" class="d-flex flex-row justify-content-evenly align-items-center mb-3">
            <select class="form-select" id="patente" name="patente">
                <option selected value="-1">Seleccione una Patente</option>
            </select>
        </div>

        <?php if (isset($validacion) && $validacion->hasError('zona')) { ?>
            <span class="text-danger"> <?= "*".$validacion->getError('zona'); ?> </span>
        <?php } ?>
        <div id="seleccionZona" class="d-flex flex-row justify-content-evenly align-items-center mb-3">
            <select class="form-select" id="zonas" name="zona" disabled onchange="traerHorarios(this.value)">
                <option selected value="-1">Seleccione una Zona</option>
            </select>
            <div id="spinner" class="spinner-border text-primary spinner-border-sm ms-2" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
        <?php if (isset($validacion) && $validacion->hasError('horario')) { ?>
            <span class="text-danger"> <?= "*".$validacion->getError('horario'); ?> </span>
        <?php } ?>
        <div id="seleccionHorario" class="d-flex flex-row justify-content-evenly align-items-center mb-3">
            <select class="form-select" id="horarios" name="horario" disabled onchange="crearHorarios(this.value)">
                <option selected value="-1">Seleccione un Horario</option>
            </select>
            <div id="spinner-horario" class="d-none spinner-border text-primary spinner-border-sm ms-2" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>

        <div class="m-auto d-flex flex-row justify-content-between align-items-center">
            <div>
                <?php if (isset($validacion) && $validacion->hasError('fecha')) { ?>
                    <span class="text-danger"> <?= "*".$validacion->getError('fecha'); ?> </span>
                <?php } ?>
                <div class="tui-datepicker-input tui-datetime-input tui-has-focus mb-3">
                    <input id="datepicker-input" type="text" name="fecha" aria-label="Date" autocomplete="off">
                    <span class="tui-ico-date"></span>
                    <div id="wrapper_date_inicial" style="margin-left: -1px;"></div>
                </div>
            </div>

            <div>
                <?php if (isset($validacion) && $validacion->hasError('horaInicial')) { ?>
                    <span class="text-danger"> <?= "*".$validacion->getError('horaInicial'); ?> </span>
                <?php } ?>
                <div class="mb-3">
                    <div>Hora Inicial</div>
                    <div id="horaInicial-input"></div>
                </div>
                <?= form_hidden('horaInicial'); ?>


            

                <b>Horario INDEFINIDO</b>
                <input type="checkbox" checked="" name="check" id="check" value="1" onchange="javascript:showContent()" />
               
                <div id="content" style="display: none;">
             

                <?php if (isset($validacion) && $validacion->hasError('horaFinal')) { ?>
                    <span class="text-danger"> <?= "*".$validacion->getError('horaFinal'); ?> </span>
                <?php } ?>
                <div class="form-floating mb-3">
                    <div>Hora Final</div>
                    <div id="horaFinal-input"></div>
                </div>
                <?= form_hidden('horaFinal'); ?>


                </div>

            </div>
        </div>

        <div style="text-align: center">
            <button type="button" class="btn btn-primary" id="enviar" onclick="estaIndefinido()">Enviar</button>
        </div>
    </form>
</div>

<!-- Modal (previsualización) -->
<div class="modal fade" id="modalPrevisualizacion" aria-labelledby="previsualizacionModelLabel" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="previsualizacionModelLabel">Previsualizacion del Costo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Esta transaccion costaria: <span id="resultadoContainer"></span></p>
                <div id="grow" class="d-flex justify-content-center"></div>
                <p>¿Confirmar la Estadia?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal" id="btn-enviar" disabled onclick="vehiculoExiste()">Si</button>
            </div>
        </div>
    </div>
</div>




<div class="modal fade" id="modalCarga" aria-labelledby="cargaModelLabel" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="previsualizacionModelLabel">Carga Vehiculo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h3>No existe vehiculo con esta patente, ¿desea agregarlo?</h3>
                <form id="formCarga" method="post" action="<?= base_url('usuarios/clientes/vender') ?>">
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

<script src="https://uicdn.toast.com/tui.time-picker/latest/tui-time-picker.js"></script>
<script src="https://uicdn.toast.com/tui.date-picker/latest/tui-date-picker.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/locale/es.min.js" integrity="sha512-L6Trpj0Q/FiqDMOD0FQ0dCzE0qYT2TFpxkIpXRSWlyPvaLNkGEMRuXoz6MC5PrtcbXtgDLAAI4VFtPvfYZXEtg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript">
    const horasYMinutos = (horario) =>
    {
        return { hour: horario.hour(), minute: horario.minute() }
    }

    const momentConHora = (horario) =>
    {
        return moment('1-1-2021 ' + horario, 'D-M-YYYY H:m:s')
    }

    const modMoment = (horario, campo, cantidad, operacion) =>
    {
        let clon = moment(horario)
        if (operacion === 'add')
            return clon.add(cantidad, campo)
        else
            return clon.subtract(cantidad, campo)
    }

    const crearHorarios = (horario) => {
        if (horario > 0)
        {
            fetch("<?= esc(base_url('usuarios/clientes/horarios')) ?>", {
                method: 'GET',
                headers: { 'horario': horario }
            })
                .then(response => response.json())
                .then(data => {
                    let ahora = moment()
                    let horarioInicio = momentConHora(data.horario['hora_inicio'])
                    let horarioFin = momentConHora(data.horario['hora_fin'])

                    let datePicker = new tui.DatePicker('#wrapper_date_inicial', {
                        date: ahora,
                        input: {
                            element: '#datepicker-input',
                            format: 'dd-MM-yyyy'
                        }
                    })

                    let horaInicialPicker = new tui.TimePicker('#horaInicial-input', {
                        inputType: 'selectbox',
                        showMeridiem: false
                    })
                    horaInicialPicker.setRange(horasYMinutos(horarioInicio), horasYMinutos(modMoment(horarioFin, 'minutes', 29, 'sub')))

                    let horaFinalPicker = new tui.TimePicker('#horaFinal-input', {
                        inputType: 'selectbox',
                        showMeridiem: false
                    })
                    horaFinalPicker.setRange(horasYMinutos(modMoment(horarioInicio, 'minutes', 20, 'add')), horasYMinutos(horarioFin))

                    horaInicialPicker.on('change', (hr) => {
                        horaFinalPicker = new tui.TimePicker('#horaFinal-input', {
                            inputType: 'selectbox',
                            showMeridiem: false
                        })
                        horaFinalPicker.setRange(horasYMinutos(modMoment(hr, 'minutes', 20, 'add')), horasYMinutos(horarioFin))
                    })
                })
        }
    }

    const cargarVehiculo = () => {
        let patente = document.getElementById('patente').value
        let formData = new FormData(document.getElementById('formCarga'))
        formData.append('patente', patente)

        let errorMensaje = document.querySelectorAll('.errorMensaje')
        for (let elemento of errorMensaje)
        {
            elemento.parentNode.removeChild(elemento)
        }

        fetch("<?= base_url('usuarios/clientes/guardarVehiculo') ?>", {
            method: 'POST',
            body: formData
        })
            .then(response => {
                if (response.status == 200)
                {
                    let formulario = document.getElementById('formulario')
                    formulario.submit()
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
                    let modalErrores = new bootstrap.Modal(document.getElementById('modalErrores'))

                    for (let llave in data)
                    {
                        console.log(data[llave])
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

    const vehiculoExiste = () => {
        let formulario = document.getElementById('formulario')
        let modalCarga = new bootstrap.Modal(document.getElementById('modalCarga'))
        let hiddenInicial = document.getElementsByName('horaInicial')[0]
        let hiddenFinal = document.getElementsByName('horaFinal')[0]
        let pickerInicial = document.querySelectorAll('#horaInicial-input select')
        let pickerFinal = document.querySelectorAll('#horaFinal-input select')
        let patente = document.getElementById('patente').value

        hiddenInicial.value = pickerInicial[0].value + ":" + pickerInicial[1].value + ":00"
        hiddenFinal.value = pickerFinal[0].value + ":" + pickerFinal[1].value + ":00"

        fetch("<?= base_url('usuarios/clientes/obtenerVehiculo') ?>/" + patente, { method: 'GET' })
            .then(response => response.json())
            .then(auto => {
                if (auto)
                {
                    formulario.submit()
                }
                else
                {
                    modalCarga.show()
                }
            })
    }

    const checkActivo = () => {
        let formulario = document.getElementById('formulario')
        let modalCarga = new bootstrap.Modal(document.getElementById('modalCarga'))
        let hiddenInicial = document.getElementsByName('horaInicial')[0]
        let hiddenFinal = document.getElementsByName('horaFinal')[0]
        let pickerInicial = document.querySelectorAll('#horaInicial-input select')
        let pickerFinal = document.querySelectorAll('#horaFinal-input select')
        let patente = document.getElementById('patente').value

        hiddenInicial.value = pickerInicial[0].value + ":" + pickerInicial[1].value + ":00"
        hiddenFinal.value = pickerFinal[0].value + ":" + pickerFinal[1].value + ":00"

        formulario.submit();
    }
   

    const previsualizar = () => {
        let btnEnviar = document.getElementById('btn-enviar')
        let grow = document.getElementById('grow')
        let myModal = new bootstrap.Modal(document.getElementById('modalPrevisualizacion'))
        let cargando = document.createElement('div')
        let grower = document.createElement('span')
        let fecha = document.getElementById('datepicker-input').value
        let pickerInicial = document.querySelectorAll('#horaInicial-input select')
        let pickerFinal = document.querySelectorAll('#horaFinal-input select')
        let zona = document.getElementById('zonas').value
        let horario = document.getElementById('horarios').value
        let resultado = document.getElementById('resultadoContainer')
        resultado.innerText = ""

        cargando.classList.add('spinner-grow')
        cargando.classList.add('text-primary')
        cargando.setAttribute('role', 'status')
        grower.classList.add('visually-hidden')
        grower.innerText = 'Loading...'
        cargando.appendChild(grower)
        grow.append(cargando)
        myModal.show()

        fetch("<?= esc(base_url('usuarios/clientes/precio')) ?>", {
            method: 'GET',
            headers: { // Para previsualizar una venta no hace falta conocer el vehiculo, no acepta un header con un guion bajo de llave
                'zona': zona,
                'horario': horario,
                'fecha': fecha,
                'horaInicial': pickerInicial[0].value + ":" + pickerInicial[1].value + ":00",
                'horaFinal': pickerFinal[0].value + ":" + pickerFinal[1].value + ":00",
            }
        })
            .then(response => response.json())
            .then(data => {
                grow.removeChild(cargando)
                if (data && data.precio)
                {
                    resultado.innerText = data.precio.toFixed(3)
                    btnEnviar.removeAttribute('disabled')
                }
                else if (data && data.validacion)
                {
                    let divError = document.createElement('div')
                    divError.classList.add('text-danger')

                    for (let key in data.validacion)
                    {
                        let pError = document.createElement('p')
                        pError.innerText = data.validacion[key]
                        divError.appendChild(pError)
                    }
                    resultado.appendChild(divError)
                }
            })
    }

    const traerHorarios = (zona) => {
        let opciones = document.querySelectorAll('.opcionHorario')
        for (let elemento of opciones) {
            elemento.parentNode.removeChild(elemento)
        }
        let horarios = document.getElementById('horarios')
        horarios.disabled = false

        if (zona)
        {
            let spinnerHorario = document.getElementById('spinner-horario')
            spinnerHorario.classList.remove('d-none')

            fetch("<?= esc(base_url('usuarios/clientes/horarios')) ?>", {
                method: 'GET',
                headers: { 'zona': zona }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.horarios.length > 0)
                    {
                        for (let horario of data.horarios)
                        {
                            let opcion = document.createElement('option')
                            opcion.setAttribute('value', horario.id_horario)
                            opcion.innerText = horario.hora_inicio + " - " + horario.hora_fin
                            opcion.classList.add('opcionHorario')
                            horarios.appendChild(opcion)
                        }

                        horarios.disabled = false
                    }
                    else
                    {
                        console.log('No se encontraron horarios')
                    }
                    spinnerHorario.classList.add('d-none')
                })
        }
    }

    fetch("<?= esc(base_url('usuarios/clientes/zonas')) ?>", { method: 'GET' })
        .then(response => response.json())
        .then(data => {
            let zonasInput = document.getElementById('zonas')
            let spinner = document.getElementById('spinner')

            for (let zona of data.zonas)
            {
                let opcion = document.createElement('option')
                opcion.setAttribute('value', zona.id_zona)
                opcion.innerText = zona.nombre_zona
                zonasInput.append(opcion)
            }

            zonasInput.disabled = false
            spinner.parentNode.removeChild(spinner)
        })



        fetch("<?= esc(base_url('usuarios/clientes/autos')) ?>", { method: 'GET' })
        .then(response => response.json())
        .then(data => {
            let autosInput = document.getElementById('patente')
            let spinner = document.getElementById('spinner')

            for (let auto of data.autos)
            {
                let opcion = document.createElement('option')
                opcion.setAttribute('value', auto.patente)
                opcion.innerText = auto.patente
                autosInput.append(opcion)
            }

            autosInput.disabled = false
            spinner.parentNode.removeChild(spinner)
        })

       
        
                   function showContent() {
               
                  element = document.getElementById("content");
                  check = document.getElementById("check");
                   if (check.checked) {
                    element.style.display='none';
                    }
                    else {
                    element.style.display='block';
                      }
                    }


                    function estaIndefinido() {
                        let check = document.getElementById("check")
                        if(check)
                        {
                            if(check.checked) {
                                checkActivo();
                            } else {
                                previsualizar();
                            }
                        }
                 }



</script>