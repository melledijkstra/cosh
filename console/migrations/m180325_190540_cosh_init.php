<?php

use yii\db\Migration;

/**
 * Class m180325_190540_cosh_init
 */
class m180325_190540_cosh_init extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('transaction', [
            'id' => $this->primaryKey(),
            'ref_number' => $this->integer(),
            'iban' => $this->string()->notNull(),
            'bic' => $this->string(),
            'from_iban' => $this->string(),
            'bic_sender' => $this->string(),
            'name_sender' => $this->string(),
            'currency' => $this->string(),
            'date' => $this->date()->notNull(),
            'amount' => $this->double(2)->notNull(),
            'balance_after' => $this->double(2),
            'description' => $this->text(),
            'code' => $this->char(2),
            'transaction_reference' => $this->integer()->unsigned(),
            'category_id' => $this->integer(),
        ]);

        $this->createTable('category', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->unique(),
            'color' => $this->string()->notNull()->unique(),
        ]);

        $this->addForeignKey('fk_transaction_category1','transaction','category_id','category','id','SET NULL','CASCADE');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_transaction_category1','transaction');
        $this->dropTable('category');
        $this->dropTable('transaction');
    }

}
