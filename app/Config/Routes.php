<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// Rutas de Autenticación
$routes->get('login', 'Autentificacion\Usuario_controlador::loginForm');
$routes->post('login', 'Autentificacion\Usuario_controlador::LoginAuth');
$routes->get('registro', 'Autentificacion\Usuario_controlador::registroForm');
$routes->post('registro', 'Autentificacion\Usuario_controlador::register');
$routes->get('logout', 'Autentificacion\Usuario_controlador::logout');

// Rutas de la Librería / Cliente (Catálogo y Carrito)
$routes->get('libreria', 'Cliente\Catalogo_controlador::index');
$routes->get('libreria/catalogo', 'Cliente\Catalogo_controlador::index');
$routes->post('libreria/carrito/add', 'Cliente\Carrito_controlador::add');
$routes->get('libreria/carrito', 'Cliente\Carrito_controlador::show');
$routes->get('libreria/carrito/eliminar/(:any)', 'Cliente\Carrito_controlador::remove/$1');
$routes->get('libreria/carrito/vaciar', 'Cliente\Carrito_controlador::clear');
$routes->get('libreria/buscar', 'Libro_controlador::buscar');

// Rutas de Administración y Dashboard (Protegidas)
$routes->group('dashboard', ['filter' => 'auth'], static function ($routes) {
    $routes->get('', 'Administrador\Dashboard_controlador::index');
    
    $routes->get('libro', 'Administrador\Libro_controlador::index');
    $routes->get('libro/crear', 'Administrador\Libro_controlador::crear');
    $routes->post('libro/guardar', 'Administrador\Libro_controlador::guardar');

    $routes->get('autor', 'Administrador\Autor_controlador::index');
    $routes->get('autor/crear', 'Administrador\Autor_controlador::crear');
    $routes->post('autor/guardar', 'Administrador\Autor_controlador::guardar');
});