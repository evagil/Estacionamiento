<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Login');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(false); // Falso para que no se puedan acceder a los controladores a los que no les definimos una ruta manualmente

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.

$routes->group('', ['filter' => 'authEstaLog'], function($routes) {
    $routes->add('/', 'Login::index');
    $routes->post('ingresar', 'Login::ingresar');
    $routes->add('registro', 'Usuario::registro');
    $routes->post('guardarRegistro', 'Usuario::guardarRegistro');
});

$routes->group('usuarios', ['filter' => 'authGuard'], function($routes) {
    $routes->add('perfil', 'Usuario::perfil');
    $routes->add('salir', 'Usuario::salir');

    $routes->group('', ['filter' => 'propietaryGuard:3'], function ($routes) {
        $routes->get('obtenerDetalleUsuario/(:num)', 'Usuario::obtenerDetalleUsuario/$1');
        $routes->add('modificar/(:num)', 'Usuario::editarUsuario/$1');
        $routes->post('modificar/(:num)', 'Usuario::guardarEdicion');
    });
 
    $routes->group('clientes', ['filter' => 'rolGuard:Cliente'], function($routes) {
        $routes->add('agregarVehiculo', 'Cliente::agregarVehiculo');
        $routes->post('guardarVehiculo', 'Cliente::guardarVehiculo');
        $routes->get('vehiculos', 'Cliente::index');
        $routes->get('obtenerVehiculos', 'Cliente::obtenerVehiculos');
        $routes->get('obtenerVehiculo/(:any)', 'Cliente::obtenerVehiculo/$1');
        $routes->add('vincularVehiculo/(:any)', 'Cliente::vincularVehiculo/$1');
    });   

    $routes->group('administrador', ['filter' => 'rolGuard:Administrador'], function($routes) {
        $routes->add('listarVehiculosEstacionados', 'Admin::listarVehiculosEstacionados');
        $routes->get('obtenerVehiculosEstacionados', 'Admin::obtenerVehiculosEstacionados');
        $routes->add('listadoUsuarios', 'Admin::listarUsuarios');
        $routes->get('encontrarUsuarios', 'Admin::encontrarUsuarios');
        $routes->add('altaUsuario', 'Admin::altaUsuario');
        $routes->post('altaUsuario', 'Admin::guardarAlta');
        $routes->add('eliminar/(:num)', 'Admin::eliminar/$1');
        $routes->add('reestablecer/(:num)', 'Admin::reestablecerClave/$1');
    });

    $routes->group('inspectores', ['filter' => 'rolGuard:Inspector'], function($routes) {
        $routes->get('formulario', 'Inspector::formulario'); // Sugerencia. Cambiar nombre para que sea mas representativo, como consultaEstacionamiento
        $routes->post('envioPost', 'Inspector::enviarPost'); // Sugerencia. Cambiar nombre para que sea mas representativo, como obtenerEstacionamiento
    });

    $routes->group('vendedores', ['filter' => 'rolGuard:Vendedor'], function($routes) {
        $routes->get('vender', 'Vendedor::crearEstadia');
        $routes->post('vender', 'Vendedor::guardarEstadia');
        $routes->get('precio', 'Vendedor::precioEstadia');
        $routes->get('zonas', 'Vendedor::obtenerZonas');
        $routes->get('horarios', 'Vendedor::obtenerHorariosZona');
        $routes->post('guardarVehiculo', 'Vendedor::guardarVehiculo');
    });
});

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
