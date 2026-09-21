<?php 
namespace App\Controllers;

use App\Models\UsuarioModel;

class Auth extends BaseController{

    public function index()
    
    {
        helper(['form']);
        return view('auth/login');
    }
    
    public function login()
    {
        $session = session();
        $usuarioModel = new UsuarioModel();

        $email = trim($this->request->getVar('email'));
        $password = $this->request->getVar('password');

        $usuario = $usuarioModel->obtenerPorEmail($email);

        if ($usuario) {
            if (password_verify($password, $usuario['hash'])) {
                $sessionData = [
                    'id_usuario' => $usuario['id_usuario'],
                    'nombre' => $usuario['nombre'],
                    'apellidos' => $usuario['apellidos'],
                    'email' => $usuario['email'],
                    'rol' => $usuario['rol'],
                    'isLoggedIn' => true
                ];
                $session->set($sessionData);
                return redirect()->to('/dashboard');
            } else {
                $session->setFlashdata('error', 'Contraseña incorrecta.');
                return redirect()->back();
            }
        } else {
            $session->setFlashdata('error', 'Usuario no encontrado.');
            return redirect()->back();
        }
        
    }
    public function registerUser()
    {
        $session = session();
        $usuarioModel = new UsuarioModel();

        $datos = [
            'nombre' => trim($this->request->getVar('nombre')),
            'apellidos' => trim($this->request->getVar('apellidos')),
            'email' => trim($this->request->getVar('email')),
            'password' => $this->request->getVar('password')
        ];

        $resultado = $usuarioModel->registrarCliente($datos);

        if ($resultado['status']) {
            $session->setFlashdata('msg_success', $resultado['message']);
            return redirect()->to('/login');
        } else {
            $session->setFlashdata('error', $resultado['message']);
            $session->setFlashdata('open_modal', true);
           
        }
         return redirect()->to('/login');
    }
    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('/login');
    }
}