<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.88.1">
    <title>Proyecto</title>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.18.3/dist/bootstrap-table.min.css">

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
    <link href="<?= base_url('assets/dashboard.css') ?>" rel="stylesheet">
  </head>
  <body>
    
<header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
  <span class="navbar-brand col-md-3 col-lg-2 me-0 px-3"><?= session()->get('nombre').' '.session()->get('apellido') ?></span>
  <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="navbar-nav">
    <div class="nav-item text-nowrap">
      <a class="nav-link px-3" href="<?php echo base_url('usuarios/salir')?>">CERRAR SESION</a>
    </div>
  </div>
</header>

<div class="container-fluid">
    <div class="row">
        <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
            <div class="position-sticky pt-3">
                <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">Usuarios</h6>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="<?= base_url('usuarios/perfil') ?>">
                            <span data-feather="home"></span>
                            Inicio
                        </a>
                    </li>
                </ul>

                <?php if (session()->get('nombre_rol') === 'Administrador'): ?>
                    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">Administrador</h6>
                    <ul class="nav flex-column mb-2">
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('usuarios/administrador/listadoUsuarios') ?>">
                                <span data-feather="users"></span>
                                Listar Usuarios
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('usuarios/administrador/altaUsuario') ?>">
                                <span data-feather="plus-circle"></span>
                                Crear Usuario
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('usuarios/administrador/listarVehiculosEstacionados') ?>">
                                <span data-feather="list"></span>
                                Autos Estacionados
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('usuarios/administrador/infracciones') ?>">
                                <span data-feather="clipboard"></span>
                                Infracciones
                            </a>
                        </li>
                    </ul>
                <?php endif; ?>

                <?php if (session()->get('nombre_rol') === 'Cliente'): ?>
                    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">Cliente</h6>
                    <ul class="nav flex-column mb-2">
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('usuarios/clientes/agregarVehiculo') ?>">
                                <span data-feather="plus-circle"></span>
                                Agregar Vehiculo
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('usuarios/clientes/vehiculos') ?>">
                                <span data-feather="list"></span>
                                Ver mis Vehiculos
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('usuarios/clientes/verMisEstadias') ?>">
                                <span data-feather="play"></span>
                                Ver Mis Estadias
                            </a>
                        </li>


                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('usuarios/clientes/crear') ?>">
                                <span data-feather="shopping-cart"></span>
                                <i class="bi bi-calendar3"></i> Activar Estadia
                            </a>
                        </li>
                   
                        
                     


                    </ul>
                <?php endif; ?>

                <?php if (session()->get('nombre_rol') === 'Inspector'): ?>
                    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">Inspector</h6>
                    <ul class="nav flex-column mb-2">
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('usuarios/inspectores/estadia') ?>">
                                <span data-feather="monitor"></span>
                                Inspecionar Estadia
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('usuarios/inspectores/infraccion') ?>">
                                <span data-feather="plus-circle"></span>
                                Crear Infraccion
                            </a>
                        </li>
                    </ul>
                <?php endif; ?>

                <?php if (session()->get('nombre_rol') === 'Vendedor'): ?>
                    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">Vendedor</h6>
                    <ul class="nav flex-column mb-2">
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('usuarios/vendedores/vender') ?>">
                                <span data-feather="dollar-sign"></span>
                                Vender
                            </a>
                        </li>
                    </ul>
                <?php endif; ?>
            </div>
        </nav>

        <main class="p-3 col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1><?= $titulo ?></h1>
            </div>
            <!-- Termina el header, abajo va el contenido, despues el footer cierra estas etiquetas -->



        