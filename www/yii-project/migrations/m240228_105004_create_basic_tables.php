<?php

use yii\db\Migration;

/**
 * Class m240228_105004_create_basic_tables
 */
class m240228_105004_create_basic_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('apartment', [
            'id' => $this->primaryKey(),
            'number' => $this->integer()->notNull(),
            'square' => $this->float()->notNull(),
            'rooms' => $this->integer()->notNull(),
            'isStudio' => $this->tinyInteger()->notNull(),
            'residenceId' => $this->integer()->notNull(),
            'status' => $this->string(50)->notNull(),
        ]);

        $this->createTable('contract', [
            'id' => $this->primaryKey(),
            'contractNumber' => $this->integer()->notNull(),
            'createdAt' => $this->dateTime()->notNull(),
            'apartmentId' => $this->integer()->notNull(),
            'initialPayment' => $this->decimal(10, 2)->notNull(),
            'pricePerMeter' => $this->decimal(10, 2)->notNull(),
            'pricePerMeterDiscount' => $this->decimal(10, 2)->notNull(),
            'installmentCompletionDate' => $this->dateTime()->notNull(),
            'status' => $this->string(50)->notNull(),
        ]);

        $this->createTable('paymentEvent', [
            'id' => $this->primaryKey(),
            'userId' => $this->integer()->notNull(),
            'contractId' => $this->integer()->notNull(),
            'createdAt' => $this->dateTime()->notNull(),
            'paymentType' => $this->string(50)->notNull(),
            'amount' => $this->decimal(10, 2)->notNull(),
            'isBarter' => $this->tinyInteger()->notNull(),
            'comments' => $this->string(255),
        ]);

        $this->createTable('residentialComplex', [
            'id' => $this->primaryKey(),
            'name' => $this->string(50)->notNull(),
            'installmentCompletionDate' => $this->dateTime()->notNull(),
        ]);

        $this->createTable('user', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull(),
            'roles' => $this->string(50)->notNull(),
            'email' => $this->string()->notNull()->unique(),
            'password' => $this->string()->notNull(),
        ]);
        $this->createIndex('idx-contract-contractNumber', 'contract', 'contractNumber', true);

        $this->addForeignKey('fk_apartment_residence', 'apartment', 'residenceId', 'residentialComplex', 'id');
        $this->addForeignKey('fk_contract_apartment', 'contract', 'apartmentId', 'apartment', 'id');
        $this->addForeignKey('fk_paymentEvent_contract', 'paymentEvent', 'contractId', 'contract', 'id');
        $this->addForeignKey('fk_paymentEvent_user', 'paymentEvent', 'userId', 'user', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_paymentEvent_user', 'paymentEvent');
        $this->dropForeignKey('fk_paymentEvent_contract', 'paymentEvent');
        $this->dropForeignKey('fk_contract_apartment', 'contract');
        $this->dropForeignKey('fk_apartment_residence', 'apartment');

        $this->dropIndex('idx-contract-contractNumber', 'contract');

        $this->dropTable('user');
        $this->dropTable('residentialComplex');
        $this->dropTable('paymentEvent');
        $this->dropTable('contract');
        $this->dropTable('apartment');
    }
}