<?php 
namespace App\Models;

use CodeIgniter\Model;

class BookModel extends Model{
    protected $table      = 'libros';
    // Uncomment below if you want add primary key
    protected $primaryKey = 'id_libro';
    protected $allowedFields = ['titulo', 'isbn', 'formato', 'portada', 'precio', 'stock'];
    protected $useTimestamps = true;

    
    
}