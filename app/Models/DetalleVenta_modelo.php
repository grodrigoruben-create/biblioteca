<?php 
namespace App\Models;

use CodeIgniter\Model;

class DetalleVenta_modelo extends Model{
    protected $table      = 'detalle_venta';
    // Uncomment below if you want add primary key
    protected $primaryKey = 'id_detalle_venta';

    protected $allowedFields = ['id_venta', 'isbn', 'cantidad', 'precio', 'subtotal']; // FIX: la migración usa 'isbn' como FK a libros, no 'id_libro'
    
}