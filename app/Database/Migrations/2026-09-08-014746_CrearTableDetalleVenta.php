<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDetalleVentaTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_detalle_venta' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_venta' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'isbn' => [
                'type'       => 'VARCHAR',
                'constraint' => 17,
            ],
            'cantidad' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'precio' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
            ],
            'subtotal' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
            ],
        ]);
        $this->forge->addPrimaryKey('id_detalle_venta');
        $this->forge->addForeignKey('id_venta', 'venta', 'id_venta', 'CASCADE', 'RESTRICT');
        $this->forge->addForeignKey('isbn', 'libros', 'isbn', 'RESTRICT', 'RESTRICT');
        $this->forge->createTable('detalle_venta');
    }

    public function down()
    {
        $this->forge->dropTable('detalle_venta');
    }
}
