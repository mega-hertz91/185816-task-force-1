<?php

use yii\db\Migration;
use frontend\helpers\Date;

/**
 * Handles the creation of table `{{%role}}`.
 */
class m200130_120823_create_role_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('role', [
            'id' => $this->primaryKey('255')->unique(),
            'role' => $this->char()->notNull(),
            'created_at' => $this->dateTime()->defaultValue(Date::getDateNow())->notNull(),
            'updated_at' => $this->dateTime()->defaultValue(Date::getDateNow())->notNull()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('role');
    }
}
