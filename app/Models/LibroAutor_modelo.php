<?php 
namespace App\Models;

use CodeIgniter\Model;

class LibroAutor_modelo extends Model{
    protected $table      = 'libro_autor';
    // Uncomment below if you want add primary key
    protected $primaryKey = 'id_libro_autor';
    protected $allowedFields = ['id_libro', 'id_autor', 'created_at'];
}