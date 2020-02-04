<?php

use yii\db\Migration;
use frontend\helpers\Date;

/**
 * Handles the creation of table `{{%task}}`.
 */
class m200130_130421_create_task_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('task', [
            'id' => $this->primaryKey(),
            'category_id' => $this->integer()->notNull(),
            'title' => $this->char('255'),
            'description' => $this->text(),
            'city_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'executor_id' => $this->integer()->notNull(),
            'amount' => $this->integer(),
            'status_id' => $this->integer()->notNull(),
            'created_at' => $this->dateTime()->defaultValue(Date::getDateNow())->notNull(),
            'updated_at' => $this->dateTime()->defaultValue(Date::getDateNow())->notNull()
        ]);

        $this->addForeignKey('fkt-category_id', 'task', 'category_id', 'category', 'id');
        $this->addForeignKey('fkt-city_id', 'task', 'city_id', 'city', 'id');
        $this->addForeignKey('fkt-user_id', 'task', 'user_id', 'user', 'id');
        $this->addForeignKey('fkt-executor_id', 'task', 'executor_id', 'user', 'id');
        $this->addForeignKey('fkt-status_id', 'task', 'status_id', 'status', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('task');
        $this->dropForeignKey('fkt-category_id', 'task');
        $this->dropForeignKey('fkt-city_id', 'task');
        $this->dropForeignKey('fkt-user_id', 'task');
        $this->dropForeignKey('fkt-executor_id', 'task');
        $this->dropForeignKey('fkt-status_id', 'task');
    }
}
