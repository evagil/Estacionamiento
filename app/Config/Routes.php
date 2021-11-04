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
    $routes->add('perfil', 'Usuario::index');
    $routes->add('listar', 'Usuario::listar');
    $routes->get('encontrarUsuarios', 'Usuario::encontrarUsuarios');
    $routes->get('obtenerDetalleUsuario/(:num)', 'Usuario::obtenerDetalleUsuario/$1');
    $routes->add('alta', 'Usuario::altaUsuario');
    $routes->post('alta', 'Usuario::guardarAlta');
    $routes->add('modificar/(:num)', 'Usuario::editarUsuario/$1');
    $routes->post('modificar/(:num)', 'Usuario::guardarEdicion');
    $routes->add('reestablecer/(:num)', 'Usuario::reestablecerClave/$1');
    $routes->add('salir', 'Usuario::salir');
    $routes->add('eliminar/(:num)', 'Usuario::eliminar/$1');
    

    $routes->group('clientes', function($routes) {
        $routes->add('agregarVehiculo', 'Cliente::agregarVehiculo');
        $routes->post('guardarVehiculo', 'Cliente::guardarVehiculo');
        $routes->get('vehiculos', 'Cliente::index');
        $routes->get('obtenerVehiculos', 'Cliente::obtenerVehiculos');
        $routes->get('obtenerVehiculos/(:any)', 'Cliente::obtenerVehiculos/$1');
        $routes->get('obtenerVehiculos', 'Cliente::obtenerVehiculos');
        $routes->add('vincularVehiculo/(:any)', 'Cliente::vincularVehiculo/$1');
    });   
   
});

$routes->group('vehiculos', function($routes) {
    $routes->add('listarVehiculosEstacionados', 'AutosEstacionados::index');
    $routes->get('listarVehiculosEstacionados', 'AutosEstacionados::listar');
   
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
