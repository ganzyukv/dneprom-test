<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%city}}`.
 */
class m200401_151749_CreateCityTable extends Migration
{

    const TABLE_NAME = '{{%city}}';

    public function safeUp()
    {
        $this->createTable(self::TABLE_NAME, [
            'name' => $this->string('255')->notNull(),
            'ref' => $this->string(50)->notNull()
         ]);
        $this->addPrimaryKey('ref', self::TABLE_NAME , 'ref');
    }


    public function safeDown()
    {
        $this->dropTable(self::TABLE_NAME);
    }
}
