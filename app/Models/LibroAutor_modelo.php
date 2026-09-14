<?php 
namespace App\Models;

use CodeIgniter\Model;

class LibroAutor_modelo extends Model{
    protected $table      = 'libro_autor';
    // Uncomment below if you want add primary key
    protected $primaryKey = 'id_libro_autor';
    protected $allowedFields = ['libro_id', 'autor_id', 'created_at']; // FIX: la migración crea 'libro_id'/'autor_id', no 'id_libro'/'id_autor'
}