<?php 
namespace App\Models;

use CodeIgniter\Model;

class FormatoModel extends Model
{
    protected $table         = 'formato';
    protected $primaryKey    = 'id_formato';
    protected $allowedFields = ['nombre'];
}