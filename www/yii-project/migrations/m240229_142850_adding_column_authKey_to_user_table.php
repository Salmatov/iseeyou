<?php

use yii\db\Migration;

/**
 * Class m240229_142850_adding_column_authKey_to_user_table
 */
class m240229_142850_adding_column_authKey_to_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user','authKey',$this->string(255)->unique());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('user', 'authKey');

    }

}
