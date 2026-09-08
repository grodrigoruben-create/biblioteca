<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLibrosTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_libro' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'titulo' => [
                'type'       => 'VARCHAR',
                'constraint' => 200,
            ],
            'isbn' => [
                'type'       => 'VARCHAR',
                'constraint' => 17,
            ],
            'formato' => [
                'type'       => 'ENUM',
                'constraint' => ['pasta dura', 'rustico', 'digital'],
            ],
            'precio' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
            ],
            'stock' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'default'    => 0,
            ],
            'portada' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addPrimaryKey('id_libro');

        $this->forge->addUniqueKey('isbn');
        $this->forge->createTable('libros');
    }

    public function down()
    {
        $this->forge->dropTable('libros');
    }
}
