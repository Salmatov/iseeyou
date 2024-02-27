<?php

namespace app\models;

use yii\db\ActiveRecord;

class PaymentEvent extends ActiveRecord
{
    const INITIAL_PAYMENT = 'initial_payment';
    const MONTHLY_PAYMENT = 'monthly_payment';
    const REFUND = 'refund';


    public static function tableName()
    {
        return 'paymentEvent';
    }

    public function getContract()
    {
        return $this->hasOne(Contract::className(), ['id' => 'contractId']);
    }

    public static function getById(int $id):PaymentEvent|null
    {
        return self::findOne($id);
    }

    public static function getByArrayContractId(array $contractId, string $paymentType, string$startDate, string$endDate):array|null
    {
        return self::find()
        ->andWhere(['contractId' => $contractId])
        ->andWhere(['between', 'createdAt', $startDate, $endDate])
        ->andWhere(['paymentType' => $paymentType])
        ->all();
    }

    public static function getAll():array|null
    {
        return self::find()->all();
    }

    public static function getEventTypeList():array
    {
        return [
            self::INITIAL_PAYMENT,
            self::MONTHLY_PAYMENT,
            self::REFUND,
        ];
    }

}