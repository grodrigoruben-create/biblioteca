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

// Rutas que solo requieren sesión iniciada (cliente o administrador)
$routes->group('', ['filter' => 'Auth'], function ($routes) {
    $routes->get('dashboard', 'Dashboard::index');

    $routes->get('libreria/catalogo', [BookCartController::class, 'index']);
    $routes->post('libreria/carrito/agregar', [BookCartController::class, 'add']);
    $routes->get('libreria/carrito', [BookCartController::class, 'show']);
    $routes->post('libreria/carrito/eliminar/(:segment)', [BookCartController::class, 'remove']);
    $routes->post('libreria/carrito/vaciar', [BookCartController::class, 'clear']);
    $routes->post('libreria/carrito/finalizar', [BookCartController::class, 'finalizar']); // ← nuevo
});

// Rutas exclusivas de administrador: sesión + rol administrador
$routes->group('', ['filter' => ['Auth', 'Admin']], function ($routes) {
    $routes->get('libros/nuevo', [BookController::class, 'index']);
    $routes->post('libros/guardar', [BookController::class, 'save']);

    $routes->get('libros/(:num)/formatos', 'BookController::formatos/$1');       // ← nuevo
    $routes->post('libros/(:num)/formatos/guardar', 'BookController::guardarFormato/$1'); // ← nuevo

    $routes->get('autores/nuevo', [AuthorController::class, 'index']);
    $routes->post('autores/guardar', [AuthorController::class, 'save']);
});

