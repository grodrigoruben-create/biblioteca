<?php 
namespace App\Models;

use CodeIgniter\Model;

class Usuario_modelo extends Model{
    protected $table      = 'usuarios';
    protected $primaryKey = 'id_usuario';
    protected $allowedFields = ['nombre','apellidos', 'email', 'hash','rol', 'created_at'];

    public function obtenerPorEmail(string $email): ?array
    {
        return $this->where('email', $email)->first();
    }

    public function obtenerPorId(int $id): ?array
    {
        return $this->find($id);
    }

    public function registrarCliente(array $datos): array
    {
        if ($this->obtenerPorEmail($datos['email'])) {
            return ['status' => false, 'message' => 'El correo electronico ya se encuentra registrado.'];
        }

        $hashPassword = password_hash($datos['password'], PASSWORD_DEFAULT);
        $nuevoUsuario = [
            'nombre'    => $datos['nombre'],
            'apellidos' => $datos['apellidos'],
            'email'     => $datos['email'],
            'hash'      => $hashPassword,
            'rol'       => 'cliente'
        ];

        if ($this->insert($nuevoUsuario)) {
            return ['status' => true, 'message' => 'Registro completado con exito. Ya puedes iniciar sesion.'];
        }
        return ['status' => false, 'message' => 'Error al intentar guardar el usuario.'];
    }
}
