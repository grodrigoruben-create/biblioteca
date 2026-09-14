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
        return view('form_autor');
    }
    public function guardar()
    {
        $model = new Autor_modelo();
        
        $data = [
            'nombre'       => $this->request->getPost('nombre'),
            'apellidos'    => $this->request->getPost('apellidos'),
            'nacionalidad' => $this->request->getPost('nacionalidad'),
        ];

        // El insert() fallará automáticamente si no cumple las reglas del modelo
        if ($model->insert($data)) {
            return redirect()->to(site_url('Administrador/Autor'))->with('exito', 'Autor registrado con éxito.');
        } else {
            // Si falla, obtenemos los errores directamente del modelo con $model->errors()
            return redirect()->back()->withInput()->with('errores', $model->errors());
        }
    }
}