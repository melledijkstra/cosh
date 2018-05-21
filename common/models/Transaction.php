<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "transaction".
 *
 * @property int $id
 * @property int $ref_number
 * @property string $iban
 * @property string $bic
 * @property string $from_iban
 * @property string $bic_sender
 * @property string $name_sender
 * @property string $currency
 * @property string $date
 * @property int $amount
 * @property int $balance_after
 * @property string $description
 * @property string $code
 * @property int $transaction_reference
 * @property int $category_id
 *
 * @property Category $category
 */
class Transaction extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return 'transaction';
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['ref_number', 'transaction_reference', 'category_id'], 'integer'],
            [['iban', 'date', 'amount'], 'required'],
            [['date'], 'date', 'format' => 'Y-m-d'],
            [['description'], 'string'],
            [['amount', 'balance_after'], 'double'],
            [['iban', 'bic', 'from_iban', 'bic_sender', 'name_sender', 'currency'], 'string', 'max' => 255],
            [['code'], 'string', 'max' => 2],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels(): array
    {
        return [
            'id' => Yii::t('transaction', 'ID'),
            'ref_number' => Yii::t('transaction', 'Ref Number'),
            'iban' => Yii::t('transaction', 'Iban'),
            'bic' => Yii::t('transaction', 'Bic'),
            'from_iban' => Yii::t('transaction', 'From Iban'),
            'bic_sender' => Yii::t('transaction', 'Bic Sender'),
            'name_sender' => Yii::t('transaction', 'Name Sender'),
            'currency' => Yii::t('transaction', 'Currency'),
            'date' => Yii::t('transaction', 'Date'),
            'amount' => Yii::t('transaction', 'Amount'),
            'balance_after' => Yii::t('transaction', 'Balance After'),
            'description' => Yii::t('transaction', 'Description'),
            'code' => Yii::t('transaction', 'Code'),
            'transaction_reference' => Yii::t('transaction', 'Transaction Reference'),
            'category_id' => Yii::t('transaction', 'Category ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }
}
