<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAuthorTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_autor' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nombre' => [
                'type'       => 'VARCHAR',
                'constraint' => 200,
            ],
            'apellidos' => [
                'type'       => 'VARCHAR',
                'constraint' => 200,
            ],
            'nacionalidad' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
        ]);
        $this->forge->addPrimaryKey('id_autor');
        $this->forge->createTable('autor');
    }

    public function down()
    {
        $this->forge->dropTable('autor');
    }
}