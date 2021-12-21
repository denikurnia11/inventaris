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
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Auth\Login::index');

// Auth
$routes->get('/login', 'Auth\Login::index');
$routes->get('/daftar', 'Auth\Registrasi::index');
$routes->get('/logout', 'Auth\Login::logout');

// Admin
$routes->get('/admin', 'Admin\Inventaris::index');

// User
$routes->get('/user', 'User\Peminjaman::index');

$routes->get('api/peminjaman/(:segment)/batal', 'API\Peminjaman::batal/$1');
$routes->get('api/peminjaman/(:segment)/tolak', 'API\Peminjaman::tolak/$1');
$routes->get('api/peminjaman/(:segment)/setuju', 'API\Peminjaman::setuju/$1');
$routes->get('api/peminjaman/(:segment)/kembali', 'API\Peminjaman::kembali/$1');
$routes->resource('api/peminjaman');
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
