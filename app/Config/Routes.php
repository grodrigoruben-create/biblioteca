<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

use App\Controllers\BookCartController;
use App\Controllers\AuthorController;
use App\Controllers\BookController;

$routes->get('/', 'Auth::index');
$routes->get('login', 'Auth::index');
$routes->post('login', 'Auth::login');
$routes->post('register', 'Auth::registerUser');
$routes->get('logout', 'Auth::logout');

// Rutas con middleware de sesion
// Usa 'Auth' para que coincida con tu Filters.php
$routes->group('', ['filter' => 'Auth'], function($routes) {
    $routes->get('dashboard', 'Dashboard::index');
});

$routes->get('libreria/catalogo', [BookCartController::class, 'index']);
$routes->post('libreria/carrito/agregar', [BookCartController::class, 'add']);
$routes->get('libreria/carrito', [BookCartController::class, 'show']);
$routes->get('libreria/carrito/eliminar/(:segment)', [BookCartController::class, 'remove']);
$routes->get('libreria/carrito/vaciar', [BookCartController::class, 'clear']);

$routes->get('libros/nuevo', [BookController::class, 'index']);
$routes->post('libros/guardar', [BookController::class, 'save']);

$routes->get('autores/nuevo', [AuthorController::class, 'index']);
$routes->post('autores/guardar', [AuthorController::class, 'save']);
