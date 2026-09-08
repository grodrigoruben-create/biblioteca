<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Usuario_modelo;

class Usuario_controlador extends BaseController
{
    public function loginForm()
    {
        //helper(['form']);
        return view('Login');
    }

    public function registroForm()
    {
        //helper(['form']);
        return view('Registro');
    }

    public function register()
    {
        $validation = \Config\Services::validation();
        $rules = [
            'nombre' => 'required|min_length[3]|max_length[50]',
            'apellidos' => 'required|min_length[3]|max_length[50]',
            'email' => 'required|valid_email|is_unique[usuarios.email]',
            'password' => [
                'label' => 'Contraseña',
                'rules' => 'required|min_length[8]|regex_match[/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/]',
            ],
            'errors' => [

                'regex_match' => 'La contraseña debe tener al menos 8 caracteres, incluyendo una letra mayúscula, una letra minúscula, un número y un carácter especial.',
                'min_length' => 'La contraseña debe tener al menos 8 caracteres.',
                'email' => [
                    'is_unique' => 'El correo electrónico ya está registrado.'
                ]
            ]
        ];
       if (!$this->validate($rules)) {
            return view('Registro', [
                'validation' => $this->validator
            ]);
        }

        $model = new Usuario_modelo();
        $data = [
            'nombre' => $this->request->getPost('nombre'),
            'apellidos' => $this->request->getPost('apellidos'),
            'email' => $this->request->getPost('email'),
            'hash' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'rol' => 'cliente'
        ];

        if ($model->insert($data)) {
            session()->setFlashdata('exito', 'Registro completado con éxito. Ahora puedes iniciar sesión.');
            return redirect()->to('/login');
        } else {
            session()->setFlashdata('error', 'Error al registrar el usuario. Por favor, inténtalo de nuevo.');
            return redirect()->back()->withInput();
        }
    }
    
    public function LoginAuth()
    {
        $session  = session();
        $model    = new Usuario_modelo();

        $email    = trim($this->request->getPost('email'));
        $password = $this->request->getPost('password');

        $user = $model->obtenerPorEmail($email);

        if ($user && password_verify($password, $user['hash'])) {
            $sessionData = [
                'id'          => $user['id_usuario'],
                'nombre'      => $user['nombre'],
                'apellidos'   => $user['apellidos'],
                'email'       => $user['email'],
                'rol'         => $user['rol'],
                'isLoggedIn'  => true,   // antes: isLogggedIn (typo, 3 "g")
            ];

            $session->set($sessionData);
            $session->regenerate();

            return redirect()->to('dashboard'); // antes: return view('index')
        }

        $session->setFlashdata('msg_error', 'Correo o contraseña incorrectos.');
        return redirect()->to('/')->withInput();
    }

    public function registerSave()
    {

        $session = session();
        $model   = new Usuario_modelo();

        $datos = [
            'nombre'     => trim($this->request->getPost('nombre')),
            'apellidos'  => trim($this->request->getPost('apellidos')),
            'email'      => trim($this->request->getPost('email')),
            'password'   => trim($this->request->getPost('password')),
        ];
        // Ejecución de registro con validación en el modelo
        $resultado = $model->registrarCliente($datos);

        if ($resultado['status']) {
            $session->setFlashdata('msg_success', $resultado['message' ]);
        } else {
            $session->setFlashdata('msg_error', $resultado['message' ]);
            $session->setFlashdata('open_modal', true); // Reabre el modal al fallar
        }
        return redirect()->to('/login');
    }
        
    public function logout ()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}