<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\Cliente\Carrito_controlador;
use App\Controllers\Autentificacion\Usuario_controlador;
use App\Controllers\Dashboard_controlador;
use App\Controllers\Libro_controlador;
use App\Controllers\Autor_controlador;

/**
 * @var RouteCollection $routes
 */

// Landing y Públicas (Catálogo principal)
$routes->get('/', [Carrito_controlador::class, 'index']);

// Autenticación
$routes->get('login', [Usuario_controlador::class, 'loginForm']);
$routes->post('login', [Usuario_controlador::class, 'LoginAuth']);
$routes->get('registro', [Usuario_controlador::class, 'registroForm']);
$routes->post('registro', [Usuario_controlador::class, 'register']);
$routes->get('logout', [Usuario_controlador::class, 'logout']);

// Rutas protegidas (Requieren sesión iniciada con el filtro 'auth')
$routes->group('', ['filter' => 'auth'], function ($routes) {
    $routes->get('dashboard', [Dashboard_controlador::class, 'index']);

    // Gestión de Autores (Panel de Administración)
    $routes->get('Administrador/Autor', [Autor_controlador::class, 'index']);
    $routes->get('Administrador/Autor/crear', [Autor_controlador::class, 'crear']);
    $routes->post('Administrador/Autor/guardar', [Autor_controlador::class, 'guardar']);

    // Gestión de Libros (Panel de Administración)
    $routes->get('Administrador/Libro', [Libro_controlador::class, 'index']);
    $routes->get('Administrador/Libro/crear', [Libro_controlador::class, 'crear']);
    $routes->post('Administrador/Libro/guardar', [Libro_controlador::class, 'guardar']);
});

// Tienda y Carrito
$routes->get('libreria/catalogo', [Carrito_controlador::class, 'index']);
$routes->post('libreria/carrito/add', [Carrito_controlador::class, 'add']); // Corregido: coincide con el formulario (add en lugar de agregar)
$routes->get('libreria/carrito', [Carrito_controlador::class, 'show']);
$routes->get('libreria/carrito/eliminar/(:segment)', [Carrito_controlador::class, 'remove/$1']); // Corregido: se agrega '$1' para pasar la clave al método
$routes->get('libreria/carrito/vaciar', [Carrito_controlador::class, 'clear']);
$routes->get('libros/buscar', [Carrito_controlador::class, 'index']);