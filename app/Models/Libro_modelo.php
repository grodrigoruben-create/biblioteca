<?php 
namespace App\Models;

use CodeIgniter\Model;

class Libro_modelo extends Model{
    protected $table      = 'libros';
    // Uncomment below if you want add primary key
    protected $primaryKey = 'id_libro';
    protected $returnType       = 'array';
    protected $allowedFields = ['titulo', 'isbn', 'formato', 'precio', 'stock', 'portada', 'created_at'];

    // Las validaciones se mudan aquí
    protected $validationRules = [
        'titulo'  => 'required|min_length[2]|max_length[200]',
        'isbn'    => 'required|min_length[10]|max_length[17]|is_unique[libros.isbn]',
        'formato' => 'required|in_list[pasta dura,rustico,digital]',
        'precio'  => 'required|decimal',
        'stock'   => 'required|integer|greater_than_equal_to[0]'
    ];

    protected $validationMessages = [
        'isbn' => [
            'is_unique' => 'Este ISBN ya está registrado en otro libro.'
        ]
    ];
}
