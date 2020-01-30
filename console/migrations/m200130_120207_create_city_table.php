<?php

use yii\db\Migration;
use frontend\helpers\Date;

/**
 * Handles the creation of table `{{%city}}`.
 */
class m200130_120207_create_city_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('city', [
            'id' => $this->primaryKey('255')->unique(),
            'name' => $this->text()->notNull(),
            'created_at' => $this->dateTime()->defaultValue(Date::getDateNow())->notNull(),
            'updated_at' => $this->dateTime()->defaultValue(Date::getDateNow())->notNull()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('city');
    }
}
