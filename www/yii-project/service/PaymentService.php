<?php

namespace app\service;

use app\dto\ContractWithDebtDTO;
use app\dto\GetContractsWithDebtDTO;
use app\dto\GetUnderpaymentMonthlyPaymentSumDTO;
use app\dto\GetUnderpaymentFirstPaymentSumDTO;
use app\helpers\DateTimeHelper;
use app\models\Contract;
use app\models\PaymentEvent;

class PaymentService
{

    public static function getUnderpaymentInitialPaymentSum(GetUnderpaymentFirstPaymentSumDTO $dto)
    {
        $contracts =  Contract::getByResidenceIdAndTimeIntervalAndStatusAndRooms($dto->residentialId,$dto->startDate,$dto->endDate,$dto->status,$dto->roomsFilter);
        $arrayContractId = [];
        $sumAllContracts = 0;
        foreach ($contracts as $contract) {
            $arrayContractId[] = $contract->id;
            $sumAllContracts += $contract->initialPayment;
        }
        $eventFirstPayment = PaymentEvent::getByArrayContractId($arrayContractId, PaymentEvent::INITIAL_PAYMENT, $dto->startDate, $dto->endDate);
        $eventFirstPaymentSum = PaymentEventService::getSumAmount($eventFirstPayment);
        $refundPayment = PaymentEvent::getByArrayContractId($arrayContractId,PaymentEvent::REFUND,$dto->startDate,$dto->endDate);
        $refundPaymentSum = PaymentEventService::getSumAmount($refundPayment);
        $result = $sumAllContracts-($eventFirstPaymentSum-$refundPaymentSum);
        return $result;

    }

    public static function getUnderpaymentMonthlyPaymentSum(GetUnderpaymentMonthlyPaymentSumDTO $dto)
    {
        $contracts = Contract::getByResidenceIdAndTimeIntervalAndStatusAndRooms($dto->residenceId, '', $dto->endDate, $dto->status, $dto->roomsFilter);
        $data = [];
        $arrayContractId = [];
        foreach ($contracts as $contract) {
            $arrayContractId[] = $contract->id;
            $data[$contract ['id']]['selectedInterval'] = min(
                DateTimeHelper::getMonthDifference($dto->startDate, $dto->endDate),
                DateTimeHelper::getMonthDifference($contract->createdAt, $dto->endDate)
            );
            $data[$contract ['id']]['monthlyPaymentUnderContract'] = (int)$contract->getMonthlyPayment();
            $data[$contract ['id']]['amountMonthlyPaymentForSelectedIntervalUnderContract'] = $data[$contract ['id']]['monthlyPaymentUnderContract'] * $data[$contract ['id']]['selectedInterval'];
            $data[$contract ['id']]['actualPaymentsForSelectedInterval'] = 0;

        }
        $eventMonthlyPayment = PaymentEvent::getByArrayContractId($arrayContractId, PaymentEvent::MONTHLY_PAYMENT, $dto->startDate, $dto->endDate);
        foreach ($eventMonthlyPayment as $event) {
            $data[$event['contractId']]['actualPaymentsForSelectedInterval'] += $event['amount'];
        }
        $debt = 0;
        foreach ($data as $key => $value) {
            $data[$key]['underpayment'] = $value['amountMonthlyPaymentForSelectedIntervalUnderContract'] - $value['actualPaymentsForSelectedInterval'];
            $debt += $data[$key]['underpayment'];
        }

        return $debt;
    }


    public static function heOwes(Contract $contract)
    {
    }


    public static function getContractsWithDebt(GetContractsWithDebtDTO $dto)
    {
        $contracts = Contract::getByResidenceIdAndTimeIntervalAndStatusAndRooms(
            $dto->residenceId, '', '', $dto->status, $dto->roomsFilter
        );
        $arrayContractId = [];
        foreach ($contracts as $contract) {
            $arrayContractId[] = $contract->id;
        }
        $payments = PaymentEvent::getByArrayContractId($arrayContractId, PaymentEvent::MONTHLY_PAYMENT, '', '');
        $contractsWithDebt = [];
        foreach ($contracts as $contract) {
            $contractId = $contract->id;
            $contractTotalAmount = $contract->getAmountAllPaymentsUnderContract();
            $totalPayments = 0;
            foreach ($payments as $payment) {
                if ($payment->contractId === $contractId) {
                    $totalPayments += $payment->amount;
                }
            }
            $debt = $contractTotalAmount - $totalPayments;
            if ($debt > 0) {
                $contractWithDebt = new ContractWithDebtDTO($contract, $totalPayments, $debt);
                $contractsWithDebt[] = $contractWithDebt;
            }
        }
        return $contractsWithDebt;
    }


}
