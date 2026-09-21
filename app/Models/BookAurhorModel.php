<?php
namespace App\Models;

use CodeIgniter\Model;

class LibroAutorModel extends Model
{
    protected $table         = 'libro_autor';
    protected $primaryKey    = 'id_libro_autor';
    protected $allowedFields = ['libro_id', 'autor_id'];
    protected $useTimestamps = true;
    protected $updatedField  = ''; // la tabla no tiene updated_at
}