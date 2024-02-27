<?php

namespace app\dto;

use DateTime;

class PaymentEventUpdateDTO extends BaseDTO
{
    public int $id;
    public int $userId;
    public int $contractId;
    public DateTime $createdAt;
    public string $paymentType;
    public float $amount;
    public bool $isBarter;
    public string $comments;

    public function __construct($config)
    {
        $this->id = $config->id;
        $this->userId = $config->userId;
        $this->contractId = $config->contractId;
        $this->createdAt = new DateTime($config->createdAt);
        $this->paymentType = $config->paymentType;
        $this->amount = $config->amount;
        $this->isBarter = $config->isBarter;
        $config->comments ?? $this->comments = $config->comments;
    }

    public function rules()
    {
        return [
            [['id', 'userId', 'contractId', 'createdAt', 'paymentType', 'amount', 'isBarter',], 'required'],
            ['comments', 'string', 'max' => 255],
        ];
    }

}