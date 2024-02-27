<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\db\Query;

class Contract extends ActiveRecord

{
    const STATUS_ACTIVE = 'active';
    const STATUS_COMPLETED = 'completed';
    const STATUS_TERMINATION_PROCESS = 'termination_process';
    const STATUS_TERMINATION = 'termination';


    public static function tableName()
    {
        return 'contract';
    }

    public function getApartment()
    {
        return $this->hasOne(Apartment::className(), ['id' => 'apartmentId']);
    }

    public function getPaymentEvents()
    {
        return $this->hasMany(PaymentEvent::className(), ['contractId' => 'id']);
    }

    public static function getById(int $id):Contract|null
    {
        return self::findOne($id);
    }

    public static function getByDateCreation($startDate, $endDate):array|null
    {
        return self::find()
            ->andWhere(['between', 'createdAt', $startDate, $endDate])
            ->all();
    }

    public static function getSumInitialPaymentByTimeIntervalAndStatus(int $residenceId, $startDate, $endDate, $status):float
    {
        return self::find()
            ->leftJoin('apartment', 'apartment.id = contract.apartmentId')
            ->andWhere(['between', 'createdAt', $startDate, $endDate])
            ->andWhere(['status'=>$status])
            ->andWhere(['apartment.residenceId' => $residenceId])
            ->sum('initialPayment');
    }

    public static function getByResidentIdAndTimeIntervalAndStatus(int $residenceId, $startDate, $endDate, $status):array|null
    {
        return self::find()
            ->leftJoin('apartment', 'apartment.id = contract.apartmentId')
            ->andWhere(['between', 'contract.createdAt', $startDate, $endDate])
            ->andWhere(['contract.status' => $status])
            ->andWhere(['apartment.residenceId' => $residenceId])
            ->all();
    }

    public static function getByNumber(int $number):array|null
    {
        return self::find()->where(['number'=>$number])->all();
    }

    public static function getByContractNumber(int $contractNumber):Contract|null
    {
        return self::findOne(['contractNumber'=>$contractNumber]);
    }

    public static function getByApartmentId(int $apartmentId):array|null
    {
        return self::find()->where(['apartment_id'=>$apartmentId])->all();
    }

    public static function getByNumberAndId(int $number, int $id):array|null
    {
        return self::find()->where(['number'=>$number, 'id'=>$id])->all();
    }

    public static function getStatusList():array
    {
        return [
            self::STATUS_ACTIVE,
            self::STATUS_COMPLETED,
            self::STATUS_TERMINATION_PROCESS,
            self::STATUS_TERMINATION,
        ];
    }

    public static function getAll():array|null
    {
        return self::find()->all();
    }

}
