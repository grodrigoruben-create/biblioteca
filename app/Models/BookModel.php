<?php 
namespace App\Models;

use CodeIgniter\Model;
class BookModel extends Model
{
    protected $table          = 'libros';
    protected $primaryKey     = 'id_libro';
    protected $allowedFields  = ['titulo', 'portada'];
    protected $useTimestamps  = true;

    public function paginateConAutores(int $perPage = 6)
    {
        return $this->select("libros.*, GROUP_CONCAT(CONCAT(autor.nombre, ' ', autor.apellidos) SEPARATOR ', ') AS autor")
            ->join('libro_autor', 'libro_autor.libro_id = libros.id_libro', 'left')
            ->join('autor', 'autor.id_autor = libro_autor.autor_id', 'left')
            ->groupBy('libros.id_libro')
            ->paginate($perPage);
    }

    /**
     * Un solo libro, con sus autores concatenados (para el carrito)
     */
    public function obtenerConAutor(int $id): ?array
    {
        return $this->select("libros.*, GROUP_CONCAT(CONCAT(autor.nombre, ' ', autor.apellidos) SEPARATOR ', ') AS autor")
            ->join('libro_autor', 'libro_autor.libro_id = libros.id_libro', 'left')
            ->join('autor', 'autor.id_autor = libro_autor.autor_id', 'left')
            ->where('libros.id_libro', $id)
            ->groupBy('libros.id_libro')
            ->first();
    }
    
}