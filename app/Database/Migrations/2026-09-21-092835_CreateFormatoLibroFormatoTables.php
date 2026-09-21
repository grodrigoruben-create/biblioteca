<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateFormatoLibroFormatoTables extends Migration
{
    public function up()
    {
        // 1. Tabla `formato`: catálogo de presentaciones (pasta dura, rústico, digital, ...)
        $this->forge->addField([
            'id_formato' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nombre' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
        ]);
        $this->forge->addKey('id_formato', true);
        $this->forge->addUniqueKey('nombre');
        $this->forge->createTable('formato');

        // Semilla con los formatos que ya usabas como enum
        $this->db->table('formato')->insertBatch([
            ['nombre' => 'pasta dura'],
            ['nombre' => 'rustico'],
            ['nombre' => 'digital'],
        ]);

        // 2. Tabla `libro_formato`: la variante comprable (una obra + una presentación)
        $this->forge->addField([
            'id_libro_formato' => [
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
            'formato_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'isbn' => [
                'type'       => 'VARCHAR',
                'constraint' => 17,
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
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id_libro_formato', true);
        $this->forge->addUniqueKey('isbn');
        // Un libro no puede repetirse dos veces con el mismo formato
        $this->forge->addUniqueKey(['libro_id', 'formato_id'], 'libro_formato_unico');
        $this->forge->addForeignKey('libro_id', 'libros', 'id_libro', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('formato_id', 'formato', 'id_formato', 'RESTRICT', 'CASCADE');
        $this->forge->createTable('libro_formato');

        // 3. Migrar los datos existentes de `libros` (isbn/formato/precio/stock) a `libro_formato`
        if ($this->db->fieldExists('isbn', 'libros')) {
            $this->db->query("
                INSERT INTO libro_formato (libro_id, formato_id, isbn, precio, stock, created_at)
                SELECT l.id_libro, f.id_formato, l.isbn, l.precio, l.stock, l.created_at
                FROM libros l
                INNER JOIN formato f ON f.nombre = l.formato
            ");

            // 4. Repuntar la FK de detalle_venta: de libros.isbn a libro_formato.isbn
            $this->db->query('ALTER TABLE detalle_venta DROP FOREIGN KEY detalle_venta_isbn_foreign');
            $this->db->query('
                ALTER TABLE detalle_venta
                ADD CONSTRAINT detalle_venta_isbn_foreign
                FOREIGN KEY (isbn) REFERENCES libro_formato (isbn)
            ');

            // 5. Ya migrados los datos, quitar las columnas viejas de `libros`
            $this->db->query('ALTER TABLE libros DROP INDEX isbn');
            $this->forge->dropColumn('libros', ['isbn', 'formato', 'precio', 'stock']);
        }
    }

    public function down()
    {
        // Regresar las columnas a `libros`
        $this->forge->addColumn('libros', [
            'isbn' => [
                'type'       => 'VARCHAR',
                'constraint' => 17,
                'null'       => true,
                'after'      => 'titulo',
            ],
            'formato' => [
                'type'  => "ENUM('pasta dura','rustico','digital')",
                'null'  => true,
                'after' => 'isbn',
            ],
            'precio' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'null'       => true,
                'after'      => 'formato',
            ],
            'stock' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'default'    => 0,
                'after'      => 'precio',
            ],
        ]);

        // Recuperar los datos desde `libro_formato` antes de borrarla
        $this->db->query('
            UPDATE libros l
            INNER JOIN libro_formato lf ON lf.libro_id = l.id_libro
            INNER JOIN formato f ON f.id_formato = lf.formato_id
            SET l.isbn = lf.isbn, l.formato = f.nombre, l.precio = lf.precio, l.stock = lf.stock
        ');

        $this->db->query('ALTER TABLE libros ADD UNIQUE KEY isbn (isbn)');

        // Regresar la FK de detalle_venta hacia `libros`
        $this->db->query('ALTER TABLE detalle_venta DROP FOREIGN KEY detalle_venta_isbn_foreign');
        $this->db->query('
            ALTER TABLE detalle_venta
            ADD CONSTRAINT detalle_venta_isbn_foreign
            FOREIGN KEY (isbn) REFERENCES libros (isbn)
        ');

        $this->forge->dropTable('libro_formato', true);
        $this->forge->dropTable('formato', true);
    }
}