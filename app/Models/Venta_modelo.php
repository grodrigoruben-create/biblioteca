<?php 
namespace App\Models;

use CodeIgniter\Model;

class Venta_modelo extends Model{
    protected $table      = 'venta';
    // Uncomment below if you want add primary key
    protected $primaryKey = 'id_venta';
    protected $allowedFields = ['usuario_id', 'fecha', 'total', 'estado'];
}