<?php

namespace app\dto;

class GetUnderpaymentMonthlyPaymentSumDTO extends BaseDTO
{
    public array $residenceId;
    public string $startDate;
    public string $endDate;
    public string $status;
    public array $roomsFilter;

    public function __construct($config)
    {
        $this->residenceId = $config['residenceId']??[];
        $this->status = $config['status']??'';
        $this->roomsFilter = $config['roomsFilter']??[];
        if (isset($config['startDate'])) {
            $startDate = New \DateTime( $config['startDate']);
            $this->startDate = $startDate->format('Y-m-d');
        }else {
            $this->startDate = '';
        }
        if (isset($config['endDate'])) {
            $endDate = New \DateTime( $config['endDate']);
            $this->endDate = $endDate->format('Y-m-d');
        }else {
            $this->endDate = '';
        }
    }

}