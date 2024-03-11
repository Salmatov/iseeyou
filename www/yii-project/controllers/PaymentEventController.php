<?php

namespace app\controllers;

use app\dto\PaymentEventCreateDTO;
use app\service\PaymentEventService;
use DateTime;
use Yii;
use yii\rest\Controller;

class PaymentEventController extends Controller
{


    public static function actionCreate()
    {
        $paymentEventData = json_decode(Yii::$app->request->getRawBody());
        try {
            $paymentEventData->createdAt = new DateTime($paymentEventData->createdAt);
            $paymentEventDTO = new PaymentEventCreateDTO($paymentEventData);
            return PaymentEventService::create($paymentEventDTO);
        } catch (\Exception $e) {
            Yii::$app->response->setStatusCode($e->getCode());
            return ['error' => $e->getMessage()];
        }
    }
    public static function actionUpdate($id)
    {
        $paymentEventData = json_decode(Yii::$app->request->rawBody, true);
        try {
            $paymentEventData->createdAt = new DateTime($paymentEventData->createdAt);
            $paymentEventDTO = new PaymentEventCreateDTO($paymentEventData);
            $paymentEventDTO->validate();
            return PaymentEventService::update($id, $paymentEventDTO);
        }catch (\Exception $e) {
            Yii::$app->response->setStatusCode($e->getCode());
            return ['error' => $e->getMessage()];
        }
    }

    public static function actionUpdateEventType()
    {
        $paymentEventData = json_decode(Yii::$app->request->rawBody, true);
        try {
            return PaymentEventService::updateEventType($paymentEventData->id, $paymentEventData->eventType);
        }catch (\Exception $e) {
            Yii::$app->response->setStatusCode($e->getCode());
            return ['error' => $e->getMessage()];
        }
    }

    public static function actionDelete($id)
    {
        try {
            return PaymentEventService::delete($id);
        }catch (\Exception $e){
            Yii::$app->response->setStatusCode($e->getCode());
            return ['error' => $e->getMessage()];
        }
    }

    public static function actionAllPaymentEvents():array
    {
        try {
            return PaymentEventService::getAll();
        }catch (\Exception $e){
            Yii::$app->response->setStatusCode($e->getCode());
            return ['error' => $e->getMessage()];
        }
    }

}