<?php 
namespace App\Controllers;

use App\Models\Libro_modelo;
use App\Models\Autor_modelo;
use App\Models\LibroAutor_modelo;

class Libro_controlador extends BaseController{

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
        return view('Libro_crear', $data);
    }

    public function guardar()
    {
        $rules = [
            'titulo'     => 'required|min_length[2]|max_length[200]',
            'isbn'       => 'required|min_length[10]|max_length[17]|is_unique[libros.isbn]',
            'formato'    => 'required|in_list[pasta dura,rustico,digital]',
            'precio'     => 'required|decimal',
            'stock'      => 'required|integer|greater_than_equal_to[0]',
            'autores'    => 'required',
            'autores.*'  => 'is_natural_no_zero',
        ];

        if (!$this->validate($rules)) {
            $autorModel = new Autor_modelo();
            return view('Libro_crear', [
                'validation' => $this->validator,
                'autores'    => $autorModel->findAll(),
            ]);
        }

        $libroModel = new Libro_modelo();
        $data = [
            'titulo'  => $this->request->getPost('titulo'),
            'isbn'    => $this->request->getPost('isbn'),
            'formato' => $this->request->getPost('formato'),
            'precio'  => $this->request->getPost('precio'),
            'stock'   => $this->request->getPost('stock'),
        ];

        // insert() con $returnID (true por defecto) regresa el id_libro recién creado
        $idLibro = $libroModel->insert($data);

        if ($idLibro) {
            $libroAutorModel = new LibroAutor_modelo();
            $autoresSeleccionados = $this->request->getPost('autores') ?? [];

            foreach ($autoresSeleccionados as $idAutor) {
                $libroAutorModel->insert([
                    'libro_id' => $idLibro,
                    'autor_id' => $idAutor,
                ]);
            }

            session()->setFlashdata('exito', 'Libro registrado con éxito.');
        } else {
            session()->setFlashdata('error', 'No se pudo registrar el libro.');
        }

        return redirect()->to(site_url('Administrador/Libro/crear'));
    }
}