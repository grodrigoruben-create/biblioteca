<?php
namespace App\Controllers;

use App\Models\UsuarioModel;

class Auth extends BaseController
{
    public function index()
    {
        helper(['form']);
        return view('auth/login');
    }

    public function login()
    {
        if (! $this->validate([
            'email'    => 'required|valid_email',
            'password' => 'required',
        ])) {
            session()->setFlashdata('error', 'Ingresa un correo y contraseña válidos.');
            return redirect()->back()->withInput();
        }

        $usuarioModel = new UsuarioModel();
        $email        = trim($this->request->getPost('email'));
        $password     = $this->request->getPost('password');

        $usuario = $usuarioModel->obtenerPorEmail($email);

        if ($usuario && password_verify($password, $usuario['hash'])) {
            session()->regenerate(); // evita fijación de sesión

            session()->set([
                'id_usuario' => $usuario['id_usuario'],
                'nombre'     => $usuario['nombre'],
                'apellidos'  => $usuario['apellidos'],
                'email'      => $usuario['email'],
                'rol'        => $usuario['rol'],
                'isLoggedIn' => true,
            ]);

            return redirect()->to('/dashboard');
        }

        // mensaje genérico: no revela si el email existe o no
        session()->setFlashdata('error', 'Correo o contraseña incorrectos.');
        return redirect()->back()->withInput();
    }

    public function registerUser()
    {
        if (! $this->validate([
            'nombre'    => 'required|min_length[2]|max_length[100]',
            'apellidos' => 'required|min_length[2]|max_length[100]',
            'email'     => 'required|valid_email',
            'password'  => 'required|min_length[8]',
        ])) {
            session()->setFlashdata('error', implode(' ', $this->validator->getErrors()));
            session()->setFlashdata('open_modal', true);
            return redirect()->to('/login')->withInput();
        }

        $usuarioModel = new UsuarioModel();

        $datos = [
            'nombre'    => trim($this->request->getPost('nombre')),
            'apellidos' => trim($this->request->getPost('apellidos')),
            'email'     => trim($this->request->getPost('email')),
            'password'  => $this->request->getPost('password'),
        ];

        $resultado = $usuarioModel->registrarCliente($datos);

        if ($resultado['status']) {
            session()->setFlashdata('msg_success', $resultado['message']);
        } else {
            session()->setFlashdata('error', $resultado['message']);
            session()->setFlashdata('open_modal', true);
        }

        return redirect()->to('/login');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}