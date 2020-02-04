<?php

use yii\db\Migration;
use frontend\helpers\Date;

/**
 * Handles the creation of table `{{%comment}}`.
 */
class m200130_134539_create_comment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%comment}}', [
            'id' => $this->primaryKey('255')->unique(),
            'user_id' => $this->integer()->notNull(),
            'description' => $this->text(),
            'task_id' => $this->integer()->notNull(),
            'created_at' => $this->dateTime()->defaultValue(Date::getDateNow())->notNull(),
            'updated_at' => $this->dateTime()->defaultValue(Date::getDateNow())->notNull()
        ]);

        $this->addForeignKey('fkc-user_id', 'comment', 'user_id', 'user', 'id');
        $this->addForeignKey('fkc-task_id', 'comment', 'task_id', 'task', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%comment}}');

        $this->dropForeignKey('fkc-user_id', 'comment');
        $this->dropForeignKey('fkc-task_id', 'comment');
    }
}
