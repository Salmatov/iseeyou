<?php

namespace app\models;

use yii\db\ActiveRecord;

class Apartment extends ActiveRecord
{

    const STATUS_SOLD = 'sold';
    const STATUS_LOCKED = 'locked';
    const STATUS_SELL = 'sell';

    public static function tableName()
    {
        return 'apartment';
    }

    public static function getApartmentByNumber(int $number): array
    {
        return static::find()->andWhere(['like','number', $number])->all();
    }

    public function getResidence()
    {
        return $this->hasOne(ResidentialComplex::className(), ['id' => 'residenceId']);
    }

    public function getContracts()
    {
        return $this->hasMany(Contract::className(), ['apartmentId' => 'id']);
    }

    public static function getById(int $id):Apartment|null
    {
        return self::findOne($id);
    }

    public static function getByNumber(int $number):array|null
    {
        return self::find()->where(['number'=>$number])->all();
    }

    public static function getBySquare(float $square):array|null
    {
        return self::find()->where(['square'=>$square])->all();
    }

    public static function getByRooms(int $rooms):array|null
    {
        return self::find()->where(['rooms'=>$rooms])->all();
    }

    public static function getByStudio(bool $studio):array|null
    {
        return self::find()->where(['studio'=>$studio])->all();
    }

    public static function getByResidenceId(int $residenceId):array|null
    {
        return self::find()->where(['residence_id'=>$residenceId])->all();
    }

    public static function getByStatus(string $status):array|null
    {
        return self::find()->where(['status'=>$status])->all();
    }

    public static function getStatusList():array
    {
        return [
            self::STATUS_SOLD,
            self::STATUS_LOCKED,
            self::STATUS_SELL,
        ];
    }

    public static function getAll():array|null
    {
        return self::find()->all();
    }


}