<?php
namespace App\Models;

use CodeIgniter\Model;

class DetalleVentaModel extends Model
{
    protected $table         = 'detalle_venta';
    protected $primaryKey    = 'id_detalle_venta';
    protected $allowedFields = ['id_venta', 'isbn', 'cantidad', 'precio', 'subtotal'];
    protected $useTimestamps = false;
}