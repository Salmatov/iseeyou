<?php

namespace app\dto;

use DateTime;

class ContractUpdateDTO extends BaseDTO
{
    public int $id;
    public int $contractNumber;
    public DateTime $createdAt;
    public int $apartmentId;
    public float $initialPayment;
    public float $pricePerMeter;
    public float $pricePerMeterDiscount;
    public DateTime $installmentCompletionDate;
    public string $status;


    public function __construct(mixed $contractData)
    {
        $this->id = $contractData->id;
        $this->contractNumber = $contractData->contractNumber;
        $this->createdAt = $contractData->createdAt;
        $this->apartmentId = $contractData->apartmentId;
        $this->initialPayment = $contractData->initialPayment;
        $this->pricePerMeter = $contractData->pricePerMeter;
        $this->pricePerMeterDiscount = $contractData->pricePerMeterDiscount;
        $this->installmentCompletionDate = $contractData->installmentCompletionDate;
        $this->status = $contractData->status;
    }

    public function rules()
    {
        return [
            [['id', 'contractNumber', 'createdAt', 'apartmentId', 'initialPayment', 'pricePerMeter',
                'pricePerMeterDiscount', 'installmentCompletionDate', 'status'], 'required'],
            ['status', 'match', 'pattern' => '/^[a-z]+$/'],
        ];
    }
}