<?php

namespace app\controllers;

use app\dto\GetContractsWithDebtDTO;
use app\dto\GetUnderpaymentFirstPaymentSumDTO;
use app\dto\GetUnderpaymentMonthlyPaymentSumDTO;
use app\service\ContractService;
use app\service\PaymentService;
use Yii;

class AnalysisController extends \yii\rest\Controller
{

    public function actionIndex()
    {
        return 'test';
    }
    /**
     * @return float|int
     * Возвращает общую недоплату по минимальному первоначальному платежу
     */
    public static function actionUnderpaymentFirstPayment()
    {
        $requestData = Yii::$app->request->get();
        $dto = new GetUnderpaymentFirstPaymentSumDTO($requestData);
        $result = PaymentService::getUnderpaymentInitialPaymentSum($dto);
        return $result;
    }

    /**
     * @return float|int
     * Возвращает общую недоплату по ежеиесячному платежу
     */
    public static function actionUnderpaymentMonthlyPayment()
    {
        $requestData = Yii::$app->request->get();
        $dto = new GetUnderpaymentMonthlyPaymentSumDTO($requestData);
        $result = PaymentService::getUnderpaymentMonthlyPaymentSum($dto);
        return $result;
    }

    public static function actionDebtList()
    {
        $requestData = Yii::$app->request->get();
        $dto = new GetContractsWithDebtDTO($requestData);
        $contractsWithDebt = PaymentService::getContractsWithDebt($dto);
        return $contractsWithDebt;
    }


}