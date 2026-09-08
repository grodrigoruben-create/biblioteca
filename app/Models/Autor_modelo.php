<?php 
namespace App\Models;

use CodeIgniter\Model;


class Autor_modelo extends Model{
    protected $table      = 'autor';
    // Uncomment below if you want add primary key
    protected $primaryKey = 'id_autor';
    protected $allowedFields = ['nombre', 'apellidos', 'nacionalidad',];
}