<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%street}}`.
 */
class m200401_151816_CreateStreetTable extends Migration
{
    const TABLE_NAME = '{{%street}}';

    public function safeUp()
    {
        $this->createTable(self::TABLE_NAME, [
            'name' => $this->string('255')->notNull(),
            'ref'  => $this->string(50)->notNull()->unique(),
            'city_ref'  => $this->string(50)->notNull(),
        ]);

        $this->addPrimaryKey('ref', self::TABLE_NAME, 'ref');
    }


    public function safeDown()
    {
        $this->dropTable(self::TABLE_NAME);
    }
}
