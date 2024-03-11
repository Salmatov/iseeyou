<?php

namespace app\dto;

class ContractWithDebtDTO extends BaseDTO
{
    public $contract;
    public $totalPayments;
    public $debt;

    public function __construct($contract, float $totalPayments, float $debt)
    {
        $this->contract = $contract;
        $this->totalPayments = $totalPayments;
        $this->debt = $debt;
    }
}