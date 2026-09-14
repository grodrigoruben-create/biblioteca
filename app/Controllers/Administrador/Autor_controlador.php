<?php 
namespace App\Controllers;

use App\Models\Autor_modelo;

class Autor_controlador extends BaseController{

    public function index()
    {
        $model = new Autor_modelo();
        $data['autores'] = $model->findAll();
        return view('Autor_lista', $data);
    }

    public function crear()
    {
        return view('Autor_crear');
    }

    public function guardar()
    {
        $rules = [
            'nombre'       => 'required|min_length[2]|max_length[200]',
            'apellidos'    => 'required|min_length[2]|max_length[200]',
            'nacionalidad' => 'permit_empty|max_length[100]',
        ];

        if (!$this->validate($rules)) {
            return view('Autor_crear', ['validation' => $this->validator]);
        }

        $model = new Autor_modelo();
        $data = [
            'nombre'       => $this->request->getPost('nombre'),
            'apellidos'    => $this->request->getPost('apellidos'),
            'nacionalidad' => $this->request->getPost('nacionalidad'),
        ];

        if ($model->insert($data)) {
            session()->setFlashdata('exito', 'Autor registrado con éxito.');
        } else {
            session()->setFlashdata('error', 'No se pudo registrar el autor.');
        }

        return redirect()->to(site_url('Administrador/Autor/crear'));
    }
}