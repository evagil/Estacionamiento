<div class="card" style="width: 50%; margin: 0 auto">
    <div class="card-header">
        Detalles del Usuario
    </div>
    <div class="card-body" id="card-body">

    </div>
    <div class="card-footer text-muted d-flex flex-row justify-content-center">
        <a href="<?php echo base_url('administrador/modificar').'/'.$id ?>" type="button" class="btn btn-primary">Modificar</a>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script type="text/javascript">
    const agregarDetalle = (zonas) => {
        let container = document.getElementById('card-body')

        for (let key in usuario) {
            let atributo = key.charAt(0).toUpperCase() + key.slice(1);
            container.appendChild(agregarAtributo(atributo, usuario[key]))
        }
    }

    const agregarAtributo = (nombre, texto) => {
        let h5 = document.createElement('h5')
        h5.classList.add('card-title')
        h5.innerHTML = nombre.replace(/_/g, " ")

        let p = document.createElement('p')
        p.classList.add('card-text')
        p.innerHTML = texto

        let div = document.createElement('div')
        div.classList.add('p-1')
        div.appendChild(h5)
        div.appendChild(p)

        return div
    }

    $(document).ready(() => {
        $.ajax({
            method: 'GET',
            url: "<?= esc(base_url('administrador/obtenerDetalleUsuario') . '/' . $id) ?>",
            success: (zonas) => {
                agregarDetalle(zonas)
            }
        })
    })
</script>