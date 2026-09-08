<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        $libroModel = new \App\Models\libro_modelo(); // Sustituye 'LibroModel' por el nombre de tu modelo
        $data['books'] = $libroModel->findAll();

        return view('index', $data);
        }
    }