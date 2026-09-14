<?php
namespace App\Controllers\Cliente;

use App\Controllers\BaseController;
use App\Models\Libro_modelo;

class Catalogo_controlador extends BaseController
{
    public function index()
    {
        $bookModel = new Libro_modelo();
        $perPage = 6;
        
        $data = [
            'libros' => $bookModel->paginate($perPage),
            'pager'  => $bookModel->pager,
        ];
        
        // Aquí cargarías la vista de tu tienda (ej. 'Cliente/Catalogo')
        return view('Catalogo', $data);
    }
    
    // En el futuro, aquí podrías agregar métodos como:
    // public function buscar($palabraClave) { ... }
    // public function verDetalle($id) { ... }
}