<?php

namespace app\controllers;

use app\dto\GetUnderpaymentFirstPaymentSumDTO;
use app\service\UnderpaymentService;
use Yii;

class AnalysisController extends \yii\rest\Controller
{
    public static function actionUnderpaymentFirstPayment()
    {
        $requestData = Yii::$app->request->get();
        $getUnderpaymentFirstPaymentSumDTO = new GetUnderpaymentFirstPaymentSumDTO();
        $getUnderpaymentFirstPaymentSumDTO->setAttributes($requestData, false);
        $result = UnderpaymentService::getUnderpaymentInitialPaymentSum($getUnderpaymentFirstPaymentSumDTO);
        return $result;
    }

}