<?php

namespace app\dto;

class GetUnderpaymentFirstPaymentSumDTO extends BaseDTO
{
    public array $residentialId;
    public string $startDate;
    public string $endDate;
    public string $status;
    public array $roomsFilter;

    public function __construct(array $config)
    {
        $this->residentialId = $config['residenceId']??[];
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
