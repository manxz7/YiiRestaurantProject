<?php

use yii\db\Migration;

class m260318_044354_create_menus_table extends Migration
{
    public function up()
    {
        $this->createTable('menus', [
            'id'           => $this->primaryKey(),
            'name'         => $this->string()->notNull(),
            'ingredients'  => $this->text()->null(),
            'price'        => $this->decimal(8, 2)->notNull(),
            'image'        => $this->string()->null(),
            'category'     => $this->string()->notNull(),
            'is_available' => $this->boolean()->notNull()->defaultValue(true),
            'created_at'   => $this->integer()->notNull(),
            'updated_at'   => $this->integer()->notNull(),
        ]);
    }

    public function down()
    {
        $this->dropTable('menus');
    }
}