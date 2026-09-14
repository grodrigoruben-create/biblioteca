<?php

namespace App\Controllers\Autentificacion;

use App\Controllers\BaseController;
use App\Models\Usuario_modelo;

class Usuario_controlador extends BaseController
{
    public function loginForm()
    {
        helper(['form']);
        return view('Login');
    }

    public function registroForm()
    {
        helper(['form']);
        return view('Registro');
    }

    public function register()
    {
        $rules = [
            'nombre'    => 'required|min_length[3]|max_length[50]',
            'apellidos' => 'required|min_length[3]|max_length[50]',
            'email'     => [
                'rules'  => 'required|valid_email|is_unique[usuarios.email]',
                'errors' => [
                    'is_unique' => 'El correo electrónico ya está registrado.'
                ]
            ],
            'password'  => [
                'label'  => 'Contraseña',
                'rules'  => 'required|min_length[8]|regex_match[/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/]',
                'errors' => [
                    'regex_match' => 'La contraseña debe tener al menos 8 caracteres, una mayúscula, una minúscula, un número y un carácter especial.',
                    'min_length'  => 'La contraseña debe tener al menos 8 caracteres.',
                ],
            ],
        ];

        // Aplicamos el patrón PRG también en el registro para evitar reenvíos de formularios al recargar
        if (!$this->validate($rules)) {
            return redirect()->back()
                             ->withInput()
                             ->with('validation', $this->validator);
        }

        $model = new Usuario_modelo();
        $data = [
            'nombre'    => $this->request->getPost('nombre'),
            'apellidos' => $this->request->getPost('apellidos'),
            'email'     => $this->request->getPost('email'),
            'hash'      => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'rol'       => 'cliente'
        ];

        if ($model->insert($data)) {
            return redirect()->to('/login')->with('exito', 'Registro completado con éxito. Ahora puedes iniciar sesión.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Error al registrar el usuario. Por favor, inténtalo de nuevo.');
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
                'isLoggedIn'  => true,
            ];

            $session->set($sessionData);
            $session->regenerate();
            
            return redirect()->to('/dashboard');
        }

        // CORRECCIÓN: Redirigir de regreso a /login en lugar de la raíz /
        return redirect()->to('/login')->withInput()->with('msg_error', 'Correo o contraseña incorrectos.');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}