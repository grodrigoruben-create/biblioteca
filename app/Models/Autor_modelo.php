<?php 
namespace App\Models;

use CodeIgniter\Model;


class Autor_modelo extends Model{
    protected $table      = 'autor';
    // Uncomment below if you want add primary key
    protected $primaryKey = 'id_autor';
    protected $allowedFields = ['nombre', 'apellidos', 'nacionalidad',];

// Opcional: Puedes personalizar los mensajes de error
    protected $validationMessages = [
        'nombre' => [
            'required'   => 'El nombre del autor es obligatorio.',
            'min_length' => 'El nombre debe tener al menos 2 letras.'
        ],
        'apellidos' => [
            'required'   => 'Los apellidos son obligatorios.'
        ]
    ];

    // Para que valide antes de insertar o actualizar
    protected $skipValidation = false;

}