<?php 
namespace App\Models;

use CodeIgniter\Model;

class DetalleVenta_modelo extends Model{
    protected $table      = 'detalle_venta';
    // Uncomment below if you want add primary key
    protected $primaryKey = 'id_detalle_venta';

    protected $allowedFields = ['id_venta', 'id_libro', 'cantidad', 'precio', 'subtotal'];
    
}