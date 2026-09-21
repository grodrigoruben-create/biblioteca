<?php 
namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model
{
    protected $table         = 'usuarios';
    protected $primaryKey    = 'id_usuario';
    protected $allowedFields = ['nombre', 'apellidos', 'email', 'hash', 'rol', 'created_at'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = ''; // no existe updated_at en tu tabla

    protected $validationRules = [
        'nombre'    => 'required|min_length[2]|max_length[100]',
        'apellidos' => 'required|min_length[2]|max_length[100]',
        'email'     => 'required|valid_email|is_unique[usuarios.email]',
        'hash'      => 'required',
    ];

    protected $validationMessages = [
        'email' => [
            'is_unique' => 'El correo electrónico ya se encuentra registrado.',
        ],
    ];

    public function obtenerPorEmail(string $email): ?array
    {
        return $this->where('email', trim($email))->first();
    }

    public function obtenerPorId(int $id): ?array
    {
        return $this->where('id_usuario', $id)->first();
    }

    public function registrarCliente(array $datos): array
    {
        if (strlen($datos['password'] ?? '') < 8) {
            return [
                'status'  => false,
                'message' => 'La contraseña debe tener al menos 8 caracteres.',
            ];
        }

        $nuevoUsuario = [
            'nombre'    => trim($datos['nombre']),
            'apellidos' => trim($datos['apellidos']),
            'email'     => trim($datos['email']),
            'hash'      => password_hash($datos['password'], PASSWORD_DEFAULT),
            'rol'       => 'cliente',
        ];

        if (! $this->insert($nuevoUsuario)) {
            // $this->errors() trae los mensajes de is_unique, valid_email, etc.
            return [
                'status'  => false,
                'message' => implode(' ', $this->errors()),
            ];
        }

        return [
            'status'  => true,
            'message' => 'Registro completado con éxito. Ya puedes iniciar sesión.',
        ];
    }
}