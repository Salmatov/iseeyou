<?php

namespace app\models;

use app\helpers\DateTimeHelper;
use DateTime;
use yii\db\ActiveRecord;

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


    public static function getByResidenceIdAndTimeIntervalAndStatusAndRooms(array $residenceId, $startDate, $endDate, $status, $roomFilter)//:array|null
    {
        $query = self::find()
            ->leftJoin('apartment', 'apartment.id = contract.apartmentId')
            ->andWhere(['contract.status' => $status])
            ->andWhere(['apartment.residenceId' => $residenceId]);
            if ($startDate && $endDate != ''){
                $query->andWhere(['between', 'contract.createdAt', $startDate, $endDate]);
            }
        foreach ($roomFilter as $rooms) {
            $query->orWhere([
                'and',
                ['apartment.rooms' => $rooms['rooms']],
                ['apartment.isStudio' => (bool) $rooms['isStudio']]
            ]);

        }

        return $query->all();
    }

    public static function getListByNumber(int $number):array|null
    {
        return self::find()->andWhere(['like','contractNumber',$number])->all();
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

    public function getInstallmentPeriod():int
    {
        return DateTimeHelper::getMonthDifference($this->createdAt, $this->installmentCompletionDate);
    }

    public function getMonthlyPayment():float
    {
        $price = $this->apartment->square * $this->pricePerMeterDiscount;
        return ($price-$this->initialPayment)/$this->getInstallmentPeriod();
    }


    public function getAmountAllPaymentsUnderContract(): float
    {
        $currentDate = new DateTime();
        $installmentCompletionDate = new DateTime($this->installmentCompletionDate);

        if ($currentDate >= $installmentCompletionDate) {
            return $this->getMonthlyPayment() * $this->getInstallmentPeriod();
        } else {
            $startDate = new DateTime($this->createdAt);
            $monthDiff = DateTimeHelper::getMonthDifference($startDate->format('Y-m-d'), $currentDate->format('Y-m-d'));
            return $this->getMonthlyPayment() * $monthDiff;
        }
    }

}
