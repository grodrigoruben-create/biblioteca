<?php 
namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model{
    protected $table      = 'usuarios';
    // Uncomment below if you want add primary key
    protected $primaryKey = 'id_usuario';

    protected $allowedFields = ['nombre', 'apellidos', 'email', 'hash', 'rol'];
    protected $useTimestamps = false;

    public function obtenerPorEmail(string $email): ?array
    {
        return $this->where('email', $email)->first();
    }

    public function obtenerPorId(int $id): ?array
    {
        return $this->where('id_usuario', $id)->first();
    }
    public function registrarCliente(array $datos): array
    {
        if ($this->obtenerPorEmail($datos['email'])) {
            return [
                'status' => false,
                'message' => 'El correo electronico ya se encuentra registrado.'
            ];
        }
        $hashPassword = password_hash($datos['password'], PASSWORD_DEFAULT); 

        $nuevoUsuario = [ 
            'nombre' => $datos['nombre'], 
            'apellidos' => $datos['apellidos'], 
            'email' => $datos['email'], 
            'hash' => $hashPassword, 
            'rol' => 'cliente' 
            ]; 
            if ($this->insert($nuevoUsuario)) {
                return [
                    'status' => true,
                    'message' => 'Registro completado con exito. Ya puedes iniciar sesion.'
                ];
            }

            return [
                'status' => false,
                'message' => 'Error al intentar guardar el usuario.'
            ];
    }
}

