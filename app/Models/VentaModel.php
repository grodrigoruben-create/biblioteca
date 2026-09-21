<?php
namespace App\Models;

use CodeIgniter\Model;

class VentaModel extends Model
{
    protected $table         = 'venta';
    protected $primaryKey    = 'id_venta';
    protected $allowedFields = ['fecha', 'total', 'estado', 'usuario_id'];
    protected $useTimestamps = false;
}