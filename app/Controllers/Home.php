<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        $libroModel = new \App\Models\Libro_modelo(); // FIX: era 'libro_modelo' (minúscula), no coincidía con el nombre real de la clase
        $data['books'] = $libroModel->findAll();

        return view('index', $data);
        }
    }