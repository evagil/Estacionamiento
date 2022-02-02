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

/*
    $routes->group('', ['filter' => 'propietaryGuard:3'], function ($routes) { 
        $routes->get('obtenerDetalleZona/(:num)', 'Admin::obtenerDetalleZona/$1');
        $routes->add('modificar2/(:num)', 'Admin::editarZonas/$1');
        $routes->post('modificar2/(:num)', 'Admin::guardarEdicion');
    });
*/
    $routes->group('clientes', ['filter' => 'rolGuard:Cliente'], function($routes) {
        $routes->add('agregarVehiculo', 'Cliente::agregarVehiculo');
        $routes->post('guardarVehiculo', 'Cliente::guardarVehiculo');
        $routes->get('vehiculos', 'Cliente::index');
        $routes->get('obtenerVehiculo/(:any)', 'Cliente::obtenerVehiculo/$1');
        $routes->get('obtenerVehiculos', 'Cliente::obtenerVehiculos');       
        $routes->add('vincularVehiculo/(:any)', 'Cliente::vincularVehiculo/$1');
        $routes->get('saldo', 'Cliente::cargarSaldo');  #vista
        $routes->post('saldo', 'Cliente::depositarSaldo');

        # ver mis vehiculos
        $routes->add('verMisEstadias', 'Cliente::verMisEstadias');
        $routes->get('obtenerEstadiaVehiculo', 'Cliente::obtenerEstadiaVehiculo');
        $routes->get('finalizarEstadia/(:num)', 'Cliente::finalizarEstadia/$1');

        # activar ventas
        $routes->get('crear', 'Cliente::crearEstadia');
        $routes->post('crear', 'Cliente::guardarEstadia');
        $routes->get('precio', 'Cliente::precioEstadia');
        $routes->get('zonas', 'Cliente::obtenerZonas');
        $routes->get('horarios', 'Cliente::obtenerHorariosZona');
        $routes->get('autos', 'Cliente::obtenerVehiculosDelCliente');
        
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
        $routes->add('listadoZonas', 'Admin::listarZonas');
        $routes->get('obtenerZonas', 'Admin::obtenerZonas');

        $routes->get('obtenerDetalleZona/(:num)', 'Admin::obtenerDetalleZona/$1');
        $routes->add('modificar/(:num)', 'Admin::editarZonas/$1');
        $routes->post('modificar/(:num)', 'Admin::guardarEdicion');


        $routes->get('infracciones', 'Admin::listadoInfracciones');
        $routes->post('infracciones', 'Admin::obtenerInfracciones');
        $routes->post('infracciones/(:num)', 'Admin::obtenerInfracciones/$1');
    });

    $routes->group('inspectores', ['filter' => 'rolGuard:Inspector'], function($routes) {
        $routes->get('estadia', 'Inspector::consultarEstadia');
        $routes->post('estadia', 'Inspector::obtenerEstadias');
        $routes->get('infraccion', 'Inspector::crearInfraccion');
        $routes->get('infraccion/(:any)', 'Inspector::crearInfraccion/$1');
        $routes->post('infraccion', 'Inspector::guardarInfraccion');
        $routes->get('auto/(:any)', 'Inspector::obtenerAuto/$1');
        $routes->post('guardarVehiculo', 'Inspector::guardarVehiculo');
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
