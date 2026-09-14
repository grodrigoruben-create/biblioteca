<?php 
namespace App\Controllers;

class Dashboard_controlador extends BaseController{ // FIX: extendía CodeIgniter\Controller en vez de BaseController

    public function index() // FIX: no existía ningún método; login redirigía a 'dashboard' y daba 404
    {
        return view('Dashboard');
    }
}