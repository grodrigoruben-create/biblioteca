<?php 
namespace App\Controllers;

use CodeIgniter\Controller;

class Dashboard extends Controller{

    public function index()
    {
        $data = [
            'nombre'    => (string) session()->get('nombre'),
            'apellidos' => (string) session()->get('apellidos'),
            'email'     => (string) session()->get('email'),
            'rol'       => (string) session()->get('rol'),
        ];

        return view('dashboard', $data);
    }

}