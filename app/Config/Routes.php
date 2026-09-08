<?php

//use CodeIgniter\Router\RouteCollection;

/* * @var RouteCollection $routes */

//$routes->get('/', 'Home::index');
//$routes->get('index', 'Carrito_controlador::index');
//$routes->post('Carrito/agregar', 'Carrito_controlador::add');
//$routes->get('Carrito', 'Carrito_controlador::show');
/* $routes->get('Carrito/eliminar/(:segment)', 'Carrito_controlador::remove');
$routes->get('Carrito/vaciar', 'Carrito_controlador::clear');
$routes->get('Login', 'Usuario_controlador::Loginform');
$routes->post('Login', 'Usuario_controlador::LoginAuth');
$routes->get('Logout', 'Usuario_controlador::logout');
$routes->get('Registro', 'Usuario_controlador::registro');
$routes->post('Registro/guardar', 'Usuario_controlador::registerSave');
$routes->get('Administrador/Dashboard', 'Dashboard_controlador::index');
$routes->get('Administrador/Libro', 'Libro_controlador::index');
$routes->get('Administrador/Libro/crear', 'Libro_controlador::crear');
$routes->post('Administrador/Libro/guardar', 'Libro_controlador::guardar');
$routes->get('Administrador/Libro/editar/(:segment)', 'Libro_controlador::editar/$1');
$routes->post('Administrador/Libro/actualizar', 'Libro_controlador::actualizar');
$routes->get('Administrador/Libro/eliminar/(:segment)', 'Libro_controlador::eliminar/$1');
$routes->get('Administrador/Autor', 'Autor_controlador::index');
$routes->get('Administrador/Autor/crear', 'Autor_controlador::crear');
$routes->post('Administrador/Autor/guardar', 'Autor_controlador::guardar');      */


use CodeIgniter\Router\RouteCollection;
use App\Controllers\Cliente\Carrito_controlador;
use App\Controllers\Autentificacion\Usuario_controlador;
/**
 * @var RouteCollection $routes
 */

// Landing
$routes->get('/', [Carrito_controlador::class, 'index']);
$routes->get('login', [Usuario_controlador::class, 'loginForm']);
$routes->post('login', [Usuario_controlador::class, 'LoginAuth']);

$routes->get('registro', [Usuario_controlador::class, 'registroForm']);
$routes->post('registro', [Usuario_controlador::class, 'register']);

$routes->get('logout', [Usuario_controlador::class, 'logout']);


$routes->get('libreria/catalogo', [Carrito_controlador::class, 'index']);

$routes->post('libreria/carrito/agregar', [Carrito_controlador::class, 'add']);
$routes->get('libreria/carrito', [Carrito_controlador::class, 'show']);

$routes->get('libreria/carrito/eliminar/(:segment)', [Carrito_controlador::class, 'remove']);

$routes->get('libreria/carrito/vaciar', [Carrito_controlador::class, 'clear']);
$routes->get('libreria/vaciar_carrito', [Carrito_controlador::class, 'clear']);

$routes->get('libros/buscar', [Carrito_controlador::class, 'index']);