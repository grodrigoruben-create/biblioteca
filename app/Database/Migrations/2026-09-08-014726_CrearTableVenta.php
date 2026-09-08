<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateVentaTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_venta' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'fecha' => [
                'type' => 'DATETIME',
            ],
            'total' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
            ],
            'estado' => [
                'type'       => 'ENUM',
                'constraint' => ['pendiente', 'pagado', 'cancelado'],
                'default'    => 'pendiente',
            ],
            'usuario_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
        ]);
        $this->forge->addPrimaryKey('id_venta');
        $this->forge->addForeignKey('usuario_id', 'usuarios', 'id_usuario', 'RESTRICT', 'RESTRICT');
        $this->forge->createTable('venta');
    }

    public function down()
    {
        $this->forge->dropTable('venta');
    }
}
