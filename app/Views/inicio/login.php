<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.88.1">
    <title>Estacionamiento</title>

    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>

    
    <!-- Custom styles for this template -->
    <link href="<?= esc(base_url('assets/signin.css')) ?>" rel="stylesheet">
  </head>
  <body class="text-center">
    
<main class="form-signin">
  <form method="post" action="<?= base_url('ingresar') ?>">
    <img class="mb-4" src="<?= esc(base_url('assets/user.svg')) ?>" alt="" width="72" height="57">
    <h1 class="h3 mb-3 fw-normal">Ingrese su usuario</h1>

    <div class="form-floating">
      <input type="text" class="form-control" id="dni" name="dni">
      <label for="dni">
          DNI
          <?php if(isset($validacion) && $validacion->hasError('dni')): ?>
            <span class="text-danger"><?= '*'.$validacion->getError('dni') ?></span>
          <?php endif; ?>
      </label>
    </div>
    <div class="form-floating">
      <input type="password" class="form-control" id="clave" name="clave">
      <label for="clave">
          Clave
          <?php if(isset($validacion) && $validacion->hasError('clave')): ?>
              <span class="text-danger"><?= '*'.$validacion->getError('clave') ?></span>
          <?php endif; ?>
      </label>
    </div>

    <button class="w-100 btn btn-lg btn-primary mb-1" type="submit">Identificarse</button>
    <a href="<?= base_url('registro') ?>" class="w-100 btn btn-lg btn-primary">Registrarse</a>
    <p class="mt-5 mb-3 text-muted">&copy; Proyecto de Software</p>
  </form>
    <?php if (session()->getFlashdata('mensaje_error')): ?>
        <div id="mensaje" class="alert alert-warning alert-dismissible fade show" style="margin: 10px auto" role="alert">
            <?= session()->getFlashdata('mensaje_error') ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('mensaje')): ?>
        <div id="mensaje" class="alert alert-success alert-dismissible fade show" style="margin: 10px auto" role="alert">
            <?= session()->getFlashdata('mensaje') ?>
        </div>
    <?php endif; ?>
</main>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script type="text/javascript">
    $(document).ready(() => {
        setTimeout(() => {
            $('#mensaje').alert('close')
        }, 5000)
    })
</script>
</body>
</html>
