<?php

namespace app\dto;

class GetUnderpaymentFirstPaymentSumDTO extends \yii\base\Model
{
    public array $residentialId;
    public string $startDate;
    public string $endDate;
    public string $status;
    public array $roomsFilter;

    public function __construct(array $config)
    {
        $this->residentialId = $config['residenceId']??[];
        $this->startDate = $config['startDate']??'';
        $this->endDate = $config['endDate']??'';
        $this->status = $config['status']??'';
        $this->roomsFilter = $config['roomsFilter']??[];

    }
}
