<?php

namespace app\dto;

class GetUnderpaymentFirstPaymentSumDTO extends \yii\base\Model
{
    public int $residentialId = 0;
    public string $startDate = '';
    public string $endDate = '';
    public string $status = '';
}
