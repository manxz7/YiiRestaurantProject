<?php

use yii\db\Migration;

class m260318_044841_create_bookings_table extends Migration
// ⚠️ Jangan tukar nama class!
{
    public function up()
    {
        $this->createTable('bookings', [
            'id'         => $this->primaryKey(),
            'name'       => $this->string()->notNull(),
            'email'      => $this->string()->notNull(),
            'phone'      => $this->string()->notNull(),
            'date'       => $this->date()->notNull(),
            'time'       => $this->time()->notNull(),
            'people'     => $this->integer()->notNull(),
            'message'    => $this->text()->null(),
            'status'     => $this->string()->notNull()->defaultValue('pending'),
            // pending, confirmed, cancelled
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
    }

    public function down()
    {
        $this->dropTable('bookings');
    }
}