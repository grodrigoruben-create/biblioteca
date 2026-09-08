<?php 
namespace App\Models;

use CodeIgniter\Model;

class Libro_modelo extends Model{
    protected $table      = 'libros';
    // Uncomment below if you want add primary key
    protected $primaryKey = 'id_libro';
    protected $allowedFields = ['titulo', 'isbn', 'formato', 'precio', 'stock', 'portada', 'created_at'];
}