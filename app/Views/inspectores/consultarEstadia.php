<div>
    <div class="w-50 mb-5" style="margin: auto; text-align: center">
        <div class="form-floating mb-3">
            <input type="text" class="form-control" id="patente" name="patente" placeholder="Patente">
            <label for="patente">Patente</label>
        </div>
        <button id="search-button" class="btn btn-primary mb-3" onclick="newSearch()">Buscar</button>

        <div id="errors" class="mb-3 border-top border-color-dark d-none"></div>
    </div>

    <div id="search" class="row justify-content-between border-top border-dark p-3 text-center d-none"></div>

    <table class="table">
        <caption id="caption"></caption>
        <thead>
        <tr>
            <th scope="col">Hora de inicio</th>
            <th scope="col">Hora Fin</th>
            <th scope="col">Cantidad de horas</th>
            <th scope="col">Monto</th>
            <th scope="col">Zona</th>
        </tr>
        </thead>
        <tbody id="table-body">

        </tbody>
    </table>
</div>

<script type="text/javascript">
    function clearElement(elementId)
    {
        let element = document.getElementById(elementId)
        element.classList.add('d-none')

        while (element.firstChild)
        {
            element.removeChild(element.lastChild)
        }
    }

    function setNewInput(input)
    {
        let contenedor = document.getElementById('search')

        let busqueda =
            '<h5 id="search-for" class="col-2 align-self-center mb-0">\
                Patente: ' + input + '\
            </h5>\
            <button class="btn btn-warning col-2 align-self-center" onclick="crearInfraccion(\'' + input + '\')">Infraccion</button>'

        contenedor.insertAdjacentHTML('beforeend', busqueda)
        contenedor.classList.remove('d-none')
    }

    function setLoadingTable()
    {
        let body = document.getElementById('table-body')
        clearElement('table-body')

        let loadingRow =
        '<tr class="placeholder-glow">\
            <th scope="row">\
                <span class="placeholder col-5"></span>\
            </th>\
            <td>\
                <span class="placeholder col-5"></span>\
            </td>\
            <td>\
                <span class="placeholder col-5"></span>\
            </td>\
            <td>\
                <span class="placeholder col-5"></span>\
            </td>\
            <td>\
                <span class="placeholder col-5"></span>\
            </td>\
        </tr>'

        body.insertAdjacentHTML('beforeend', loadingRow)
        body.insertAdjacentHTML('beforeend', loadingRow)
        body.insertAdjacentHTML('beforeend', loadingRow)
        body.insertAdjacentHTML('beforeend', loadingRow)
        body.insertAdjacentHTML('beforeend', loadingRow)
        body.classList.remove('d-none')
    }

    function addError(error)
    {
        let errors = document.getElementById('errors')
        let message = '<p class="text-danger">' + error + '</p>'
        errors.insertAdjacentHTML('beforeend', message)
        errors.classList.remove('d-none')
    }

    function addRow(row)
    {
        return '<tr>\
                    <th scope="row">\
                        ' + row.hora_inicio + '\
                    </th>\
                    <td>\
                        ' + row.hora_fin + '\
                    </td>\
                    <td>\
                        ' + row.cantidad_horas + '\
                    </td>\
                    <td>\
                        ' + row.monto + '\
                    </td>\
                    <td>\
                        ' + row.nombre_zona + '\
                    </td>\
                </tr>'
    }

    function addElementHTML(elementId, htmlString)
    {
        clearElement(elementId)
        let element = document.getElementById(elementId)
        element.insertAdjacentHTML('beforeend', htmlString)
        element.classList.remove('d-none')
    }

    function newSearch()
    {
        let searchButton = document.getElementById('search-button')
        let input = document.getElementById('patente')
        let patenteBody = {
            patente: input.value
        }

        if (patenteBody.patente.length > 0)
        {
            searchButton.disabled = true
            clearElement('errors')
            clearElement('search')
            setLoadingTable()

            fetch('<?= base_url("usuarios/inspectores/estadia") ?>', { method: 'POST', body: JSON.stringify(patenteBody) })
                .then(response => response.json())
                .then(data => {
                    setNewInput(patenteBody.patente)
                    searchButton.disabled = false
                    addElementHTML('caption', '')

                    if (data.estadias)
                    {
                        if (data.estadias.length > 0)
                        {
                            let newTableContent = ''

                            for (let estadia of data.estadias)
                            {
                                newTableContent += addRow(estadia)
                            }

                            addElementHTML('table-body', newTableContent)
                        }
                        else
                        {
                            clearElement('table-body')
                            addElementHTML('caption', 'No se encontraron estadias activas para la patente.')
                        }
                    }
                    else
                    {
                        clearElement('search')
                        clearElement('table-body')

                        for (let error in data.errores)
                        {
                            addError(data.errores[error])
                        }
                    }
                })
        }
        else
        {
            clearElement('errors')
            addError('Ingrese una patente')
        }
    }

    function crearInfraccion(patente)
    {
        window.location.replace("<?= base_url('usuarios/inspectores/infraccion') ?>/" + patente)
    }
</script>