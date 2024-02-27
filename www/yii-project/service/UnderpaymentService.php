<?php

namespace app\service;

use app\dto\GetUnderpaymentFirstPaymentSumDTO;
use app\models\Contract;
use app\models\PaymentEvent;

class UnderpaymentService
{

    public static function getUnderpaymentInitialPaymentSum(GetUnderpaymentFirstPaymentSumDTO $dto)
    {
        $contracts =  Contract::getByResidentIdAndTimeIntervalAndStatus($dto->residentialId,$dto->startDate,$dto->endDate,$dto->status);
        $arrayContractId = [];
        $sumAllContracts = 0;
        foreach ($contracts as $contract) {
            $arrayContractId[] = $contract->id;
            $sumAllContracts += $contract->initialPayment;
        }
        $eventFirstPayment = PaymentEvent::getByArrayContractId($arrayContractId, PaymentEvent::INITIAL_PAYMENT, $dto->startDate, $dto->endDate);
        $eventFirstPaymentSum = PaymentEventService::getSumAmount($eventFirstPayment);
        $refundPayment=PaymentEvent::getByArrayContractId($arrayContractId,PaymentEvent::REFUND,$dto->startDate,$dto->endDate);
        $refundPaymentSum=PaymentEventService::getSumAmount($refundPayment);
        $result = $sumAllContracts-($eventFirstPaymentSum-$refundPaymentSum);
        return $result;


    }




}