<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLibroAutorTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_libro_autor' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'libro_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'autor_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addPrimaryKey('id_libro_autor');

        $this->forge->addForeignKey('libro_id', 'libros', 'id_libro', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('autor_id', 'autor', 'id_autor', 'CASCADE', 'CASCADE');

        $this->forge->createTable('libro_autor');
    }

    public function down()
    {
        $this->forge->dropTable('libro_autor');
    }
}