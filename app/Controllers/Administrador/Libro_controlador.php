<?php 
namespace App\Controllers;

use App\Models\Libro_modelo;
use App\Models\Autor_modelo;
use App\Models\LibroAutor_modelo;

class Libro_controlador extends BaseController
{
    public function index()
    {
        $libroModel = new Libro_modelo();
        $data['libros'] = $libroModel->findAll();
        return view('Libro_lista', $data);
    }

    public function crear()
    {
        $autorModel = new Autor_modelo();
        $data['autores'] = $autorModel->findAll();
        return view('form_libro', $data);
    }

    public function guardar()
    {
        // 1. Validar ÚNICAMENTE lo que NO pertenece a la tabla libros
        $reglasExtra = [
            'autores'   => 'required',
            'autores.*' => 'is_natural_no_zero',
        ];

        if (!$this->validate($reglasExtra)) {
            return redirect()->back()->withInput()->with('errores', $this->validator->getErrors());
        }

        $db = \Config\Database::connect();
        $db->transStart(); // Iniciamos la transacción

        $libroModel = new Libro_modelo();
        $dataLibro = [
            'titulo'  => $this->request->getPost('titulo'),
            'isbn'    => $this->request->getPost('isbn'),
            'formato' => $this->request->getPost('formato'),
            'precio'  => $this->request->getPost('precio'),
            'stock'   => $this->request->getPost('stock'),
        ];

        // 2. Intentamos insertar. El Modelo validará los datos automáticamente.
        $idLibro = $libroModel->insert($dataLibro);

        if (!$idLibro) {
            // Si fallan las validaciones del Modelo (ej. falta el título o el ISBN ya existe)
            $db->transRollback(); // Cancelamos la transacción
            return redirect()->back()->withInput()->with('errores', $libroModel->errors());
        }

        // 3. Si el libro se guardó, insertamos las relaciones en la tabla pivote
        $libroAutorModel = new LibroAutor_modelo();
        $autoresSeleccionados = $this->request->getPost('autores');

        foreach ($autoresSeleccionados as $idAutor) {
            $libroAutorModel->insert([
                'id_libro' => $idLibro,
                'id_autor' => $idAutor,
            ]);
        }

        $db->transComplete(); // Confirmamos la transacción

        // 4. Verificamos si hubo un error a nivel de base de datos
        if ($db->transStatus() === false) {
            return redirect()->back()->withInput()->with('error', 'Error interno de base de datos al guardar.');
        }

        return redirect()->to(site_url('Administrador/Libro'))->with('exito', 'Libro registrado con éxito.');
    }
}