<?php
namespace App\Controllers;

use App\Models\AuthorModel;

class AuthorController extends BaseController
{
    public function index()
    {
        helper(['form']);
        return view('FormAuthor'); // respeta mayúsculas exactas del archivo real
    }

    public function save()
    {
        $validation = \Config\Services::validation();
        $rules = [
            'nombre'       => 'required|min_length[2]|max_length[200]',
            'apellidos'    => 'required|min_length[2]|max_length[200]',
            'nacionalidad' => 'required|max_length[100]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $model = new AuthorModel();
        $model->insert([
            'nombre'       => $this->request->getPost('nombre'),
            'apellidos'    => $this->request->getPost('apellidos'),
            'nacionalidad' => $this->request->getPost('nacionalidad'),
        ]);

        return redirect()->to('/autores/nuevo')->with('success', 'Autor registrado con éxito.');
    }

}