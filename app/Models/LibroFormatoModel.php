<?php 
namespace App\Models;

use CodeIgniter\Model;

class LibroFormatoModel extends Model
{
    protected $table         = 'libro_formato';
    protected $primaryKey    = 'id_libro_formato';
    protected $allowedFields = ['libro_id', 'formato_id', 'isbn', 'precio', 'stock'];
    protected $useTimestamps = true;

    public function catalogoConDetalles(int $perPage)
    {
        return $this->select("libro_formato.*, libros.titulo, libros.portada, formato.nombre AS formato,
                GROUP_CONCAT(DISTINCT CONCAT(autor.nombre, ' ', autor.apellidos) SEPARATOR ', ') AS autor")
            ->join('libros', 'libros.id_libro = libro_formato.libro_id')
            ->join('formato', 'formato.id_formato = libro_formato.formato_id')
            ->join('libro_autor', 'libro_autor.libro_id = libro_formato.libro_id', 'left')
            ->join('autor', 'autor.id_autor = libro_autor.autor_id', 'left')
            ->groupBy('libro_formato.id_libro_formato')
            ->paginate($perPage);
    }

    public function obtenerConDetalles(int $id): ?array
    {
        return $this->select("libro_formato.*, libros.titulo, formato.nombre AS formato")
            ->join('libros', 'libros.id_libro = libro_formato.libro_id')
            ->join('formato', 'formato.id_formato = libro_formato.formato_id')
            ->where('libro_formato.id_libro_formato', $id)
            ->first();
    }
}