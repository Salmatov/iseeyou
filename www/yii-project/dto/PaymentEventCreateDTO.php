<?php

namespace app\dto;

use DateTime;

class PaymentEventCreateDTO extends BaseDTO
{
    public int $userId;
    public int $contractId;
    public DateTime $createdAt;
    public string $paymentType;
    public float $amount;
    public bool $isBarter;
    public string $comments;

    public function __construct($PaymentEventData)
    {
        $this->userId = $PaymentEventData->userId;
        $this->contractId = $PaymentEventData->contractId;
        $this->createdAt =  $PaymentEventData->createdAt;
        $this->paymentType = $PaymentEventData->paymentType;
        $this->amount = $PaymentEventData->amount;
        $this->isBarter = $PaymentEventData->isBarter;
        $this->comments = $PaymentEventData->comments;
    }

    public function rules()
    {
        return [
            [['userId', 'contractId', 'createdAt', 'paymentType', 'amount', 'isBarter',], 'required'],
            ['comments', 'string', 'max' => 255],
        ];
    }


}