<div>
    <form id="formulario" class="mb-3" style="margin: auto; text-align: center">
        <div class="row mb-3">
            <div class="col">
                <label for="inspector">Inspector</label>
                <input type="text" class="form-control" id="inspector" name="inspector" minlength="8" maxlength="8">
            </div>
            <div class="col">
                <label for="patente">Patente</label>
                <input type="text" class="form-control" id="patente" name="patente" minlength="6" maxlength="7">
            </div>
            <div class="col">
                <label for="desde">Desde</label>
                <input type="datetime-local" class="form-control" id="desde" name="desde">
            </div>
            <div class="col">
                <label for="hasta">Hasta (Incluido)</label>
                <input type="datetime-local" class="form-control" id="hasta" name="hasta">
            </div>
        </div>
        <input id="search-button" type="submit" value="Buscar" class="btn btn-primary mb-3">

        <div id="errors" class="border-top border-color-dark d-none"></div>
    </form>

    <table class="table">
        <caption id="caption"></caption>
        <thead>
        <tr>
            <th scope="col">Fecha</th>
            <th scope="col">Inspector</th>
            <th scope="col">Patente</th>
            <th scope="col">Descripcion</th>
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
                        ' + row.fecha + '\
                    </th>\
                    <td>\
                        ' + row.dni + '\
                    </td>\
                    <td>\
                        ' + row.patente + '\
                    </td>\
                    <td>\
                        ' + row.descripcion + '\
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
            </tr>'

        body.insertAdjacentHTML('beforeend', loadingRow)
        body.insertAdjacentHTML('beforeend', loadingRow)
        body.insertAdjacentHTML('beforeend', loadingRow)
        body.insertAdjacentHTML('beforeend', loadingRow)
        body.insertAdjacentHTML('beforeend', loadingRow)
        body.classList.remove('d-none')
    }

    function newSearch()
    {
        let formulario = document.getElementById('formulario')
        let formData = new FormData(formulario)
        let datos = {
            inspector: formData.get('inspector'),
            patente: formData.get('patente'),
            desde: formData.get('desde'),
            hasta: formData.get('hasta')
        }

        let searchButton = document.getElementById('search-button')
        searchButton.disabled = true
        clearElement('errors')

        fetch('<?= base_url('usuarios/administrador/infracciones') ?>',
            {
                method: 'post',
                body: JSON.stringify(datos)
            })
            .then(response => response.json())
            .then(data => {
                if (data.infracciones)
                {
                    if (data.infracciones.length > 0)
                    {
                        let rows = ""

                        for(let infraccion of data.infracciones)
                        {
                            rows += addRow(infraccion)
                        }

                        addElementHTML('table-body', rows)
                    }
                    else
                    {
                        clearElement('table-body')
                        addElementHTML('caption', 'No se encontraron estadias activas para la patente.')
                    }
                }
                else if (data.errores)
                {
                    clearElement('table-body')

                    for (let error in data.errores)
                    {
                        addError(data.errores[error])
                    }
                }

                searchButton.disabled = false
                addElementHTML('caption', '')
            })
    }

    let desde = document.getElementById('desde')
    desde.addEventListener('change', () => {
        let hasta = document.getElementById('hasta')
        hasta.min = desde.value
    })
    let formulario = document.getElementById('formulario')
    formulario.addEventListener('submit', (event) => {
        event.preventDefault()
        setLoadingTable()
        newSearch()
    })
</script>