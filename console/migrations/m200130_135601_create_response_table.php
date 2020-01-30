<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%responce}}`.
 */
class m200130_135601_create_response_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%response}}', [
            'id' => $this->primaryKey('255'),
            'user_id' => $this->integer()->notNull(),
            'amount' => $this->integer()->notNull(),
            'task_id' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey('fkr-user_id', 'response', 'user_id', 'user', 'id');
        $this->addForeignKey('fkr-task_id', 'response', 'task_id', 'task', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%response}}');

        $this->dropForeignKey('fkr-user_id', 'response');
        $this->dropForeignKey('fkr-task_id', 'response');
    }
}
