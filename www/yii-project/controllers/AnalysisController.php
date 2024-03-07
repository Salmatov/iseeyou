<?php

namespace app\controllers;

use app\dto\GetUnderpaymentFirstPaymentSumDTO;
use app\models\Contract;
use app\service\UnderpaymentService;
use Yii;

class AnalysisController extends \yii\rest\Controller
{
    /**
     * @return float|int
     * Возвращает общую недоплату по минимальному первоначальному платежу
     */
    public static function actionUnderpaymentFirstPayment()
    {
        $requestData = Yii::$app->request->get();
        $dto = new GetUnderpaymentFirstPaymentSumDTO($requestData);
        $result = UnderpaymentService::getUnderpaymentInitialPaymentSum($dto);
        return $result;
    }

}