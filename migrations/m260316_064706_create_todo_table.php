<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%todo}}`.
 */
class m260316_064706_create_todo_table extends Migration
{
    public function up()
    {
        // up() = buat table
        // Sama macam Laravel migration
        $this->createTable('todo', [
            'id'         => $this->primaryKey(),
            // primaryKey = auto increment integer, sama macam id() dalam Laravel

            'title'      => $this->string()->notNull(),
            // string = VARCHAR(255), notNull = wajib ada nilai

            'description' => $this->text()->null(),
            // text = TEXT, null = boleh kosong

            'status'     => $this->smallInteger()->notNull()->defaultValue(0),
            // smallInteger = nombor kecil
            // 0 = pending, 1 = completed

            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            // Yii2 simpan timestamp sebagai integer (unix timestamp)
            // berbeza dengan Laravel yang guna TIMESTAMP
        ]);
    }

    public function down()
    {
        // down() = undo — padam table
        // Sama macam rollback dalam Laravel
        $this->dropTable('todo');
    }
}


    