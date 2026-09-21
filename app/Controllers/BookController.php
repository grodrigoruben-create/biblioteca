<?php 
namespace App\Controllers;

use App\Models\BookModel;
use App\Models\AuthorModel;

class BookController extends BaseController
{

    public function index()
    {
        helper(['form']);

        $authorModel = new AuthorModel();

        $data = [
            'autores' => $authorModel->orderBy('apellidos', 'ASC')->findAll(),
        ];

        return view('FormBook', $data);
    }

    public function save()
        {
            $bookModel = new BookModel();
            
            // 1. Atrapamos el archivo que viene del formulario
            $archivoPortada = $this->request->getFile('portada');
            $nombrePortada = null;

            // 2. Verificamos si realmente se subió un archivo y si es válido
            if ($archivoPortada && $archivoPortada->isValid() && !$archivoPortada->hasMoved()) {
                
                // Generamos un nombre aleatorio seguro (como el que vi en tu base de datos: 178941...jpg)
                $nombrePortada = $archivoPortada->getRandomName();
                
                // Movemos físicamente el archivo a la carpeta public/uploads/
                $archivoPortada->move(FCPATH . 'uploads', $nombrePortada);
            }

            // 3. Preparamos los datos para la base de datos
            $data = [
                'titulo'  => $this->request->getPost('titulo'),
                'isbn'    => $this->request->getPost('isbn'),
                'formato' => $this->request->getPost('formato'),
                'precio'  => $this->request->getPost('precio'),
                'stock'   => $this->request->getPost('stock'),
                // Aquí guardamos el nombre aleatorio que generamos (o null si no subió foto)
                'portada' => $nombrePortada 
            ];

            // 4. Insertamos en la tabla libros
            $bookModel->insert($data);
            
            return redirect()->to('/libreria/catalogo');
        }
}